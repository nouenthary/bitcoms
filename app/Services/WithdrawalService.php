<?php

namespace App\Services;

use App\Auth\AuthManager;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Traits\Upload;


class WithdrawalService
{
    public function getWithdrawal(Request $request)
    {
        if ($request->ajax()) {
            $post = Withdrawal::leftJoin('tblwallet', 'tblwidtraw.fkwalletid', '=', 'tblwallet.walletid')
                ->join('tblwallettitle', 'tblwallet.fkwallettileid', '=', 'tblwallettitle.walletid')
                ->select(
                    'tblwidtraw.*',
                    'tblwallettitle.*',

                    DB::raw("(select name from users where id = tblwidtraw.fkuserid)  as name"),
                    DB::raw("(select image from users where id = tblwidtraw.fkuserid)  as image"),
                );

            if ($request->get('status') != '') {
                $post->where('tblwidtraw.status', $request->get('status'));
            }

            if ($request->get('start_date') != '') {
                $post->whereDate('tblwidtraw.createdate', '>=', $request->get('start_date'));
            }

            if ($request->get('end_date') != '') {
                $post->whereDate('tblwidtraw.createdate', '<=', $request->get('end_date'));
            }

            $post
                ->where('tblwidtraw.fkuserid', AuthManager::getAuthId())
                ->get();

            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->withdrawid;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json([
            'message' => 'data retrieved successfully'
        ], 200);
    }

    public function getWithdrawalWallet(Request $request)
    {
        if ($request->ajax()) {
            $post = Withdrawal::select(
                'tblwidtraw.*',

                DB::raw("(select name from users where id = tblwidtraw.fkuserid)  as name"),
                DB::raw("(select image from users where id = tblwidtraw.fkuserid)  as image"),
            );

            if ($request->get('fkuserid') != '') {
                $post->where('tblwidtraw.fkuserid', $request->get('fkuserid'));
            }

            if ($request->get('status') != '') {
                $post->where('tblwidtraw.status', $request->get('status'));
            }

            if ($request->get('start_date') != '') {
                $post->whereDate('tblwidtraw.createdate', '>=', $request->get('start_date'));
            }

            if ($request->get('end_date') != '') {
                $post->whereDate('tblwidtraw.createdate', '<=', $request->get('end_date'));
            }

            $post
                ->whereNull('tblwidtraw.fkwalletid')
                ->where('tblwidtraw.fkuserid', AuthManager::getAuthId())
                ->get();

            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->withdrawid;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json([
            'message' => 'data retrieved successfully'
        ], 200);
    }


    use Upload;

    public function createWithdrawal(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'withdrawid' => 'required',
            'fkuserid' => 'required',
            //'fkwalletid' => 'required',
            'balance' => 'required',
            'fee' => 'required',
            'totalamount' => 'required',
            'codeaddress' => 'required',
            //'codelink' => 'required',
            'status' => 'required',
            'feeamount' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (!$request->hasFile('file') && $request->get('codelink_default') == '') {
            return response()->json(['message' => ['image' => 'please upload qr image'], 'status' => false], 422);
        }

        $walletid = $request->get('fkwalletid');


        $codelink = $this->UploadFileCodeLink($request, 'codelink');

        if ($codelink == '') {
            $codelink = $request->get('codelink_default');
        }

        if ($walletid > 0) {
            $wallet = Wallet::where('walletid', $walletid)->first();

            if ($wallet->balance == 0 || $wallet->balance == '') {
                return response()->json(['message' => 'Your wallet amount balance ' . $wallet->balance, 'status' => false], 422);
            }

            Wallet::where('walletid', $walletid)
                ->update([
                    'balance' => 0,
                    'codeaddress' => $request->get('codeaddress'),
                    'codelink' => $codelink,
                ]);
        }

        if ($walletid == '') {

            $user = DB::table('users')
                ->where('id', AuthManager::getAuthId())
                ->first();

            if ($user->walletamount == 0 || $user->walletamount == '') {
                return response()->json(['message' => 'Your wallet amount balance ' . $user->walletamount, 'status' => false], 422);
            }

            DB::table('users')
                ->where('id', AuthManager::getAuthId())
                ->update([
                    'walletamount' => 0,
                    'codeaddress' => $request->get('codeaddress'),
                    'codelink' => $codelink,
                ]);
        }

        Withdrawal::create([
            'withdrawid' => 0,
            'fkuserid' => AuthManager::getAuthId(),
            'fkwalletid' => $request->get('fkwalletid'),
            'balance' => $request->get('balance'),
            'fee' => $request->get('fee'),
            'totalamount' => $request->get('totalamount'),
            'codeaddress' => $request->get('codeaddress'),
            'codelink' => $codelink,
            'status' => $request->get('status'),
            'createtime' => AuthManager::get_time(),
            'createdate' => AuthManager::get_date(),
            'userconfirmid' => '',
            'confirmtime' => '',
            'confirmdate' => '',
            'feeamount' => $request->get('feeamount'),
        ]);

        return response()->json([
            'message' => 'created successfully'
        ], 201);
    }
}
