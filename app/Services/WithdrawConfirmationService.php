<?php

namespace App\Services;

use App\Auth\AuthManager;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 * Class WithdrawConfirmationService
 * @package App\Services
 */
class WithdrawConfirmationService
{
    public function countWithdraw()
    {
        return Withdrawal::where('status', 'like', 'pending')->count();
    }

    public function getWithdraws(Request $request)
    {
        if ($request->ajax()) {
            $post = DB::table('tblwidtraw')
                ->join('users', 'tblwidtraw.fkuserid', '=', 'users.id')
                ->select(
                    'tblwidtraw.*',

                    DB::raw(
                        "(
                            select tblwallettitle.namecurencywallet from tblwallettitle 
                            inner join tblwallet on tblwallet.fkwallettileid = tblwallettitle.walletid
                            where tblwallet.walletid = tblwidtraw.fkwalletid  ) as namecurencywallet
                        "
                    ),

                    DB::raw(
                        "(
                            select tblwallettitle.namecurency from tblwallettitle 
                            inner join tblwallet on tblwallet.fkwallettileid = tblwallettitle.walletid
                            where tblwallet.walletid = tblwidtraw.fkwalletid  ) as namecurency
                        "
                    ),


                    DB::raw(
                        "(
                            select tblwallettitle.imagecurency from tblwallettitle 
                            inner join tblwallet on tblwallet.fkwallettileid = tblwallettitle.walletid
                            where tblwallet.walletid = tblwidtraw.fkwalletid  ) as imagecurency
                        "
                    ),

                    'users.name',
                    'users.image',

                    DB::raw("(select name from users where id = tblwidtraw.confirmuserid)  as user_confirm"),
                    DB::raw("(select image from users where id = tblwidtraw.confirmuserid)  as image_confirm"),

                );

            if ($request->get('status') != '') {
                $post->where('tblwidtraw.status', 'like', $request->get('status'));
            }

            $reference_code = $request->get('reference_code');
            $userid = $request->get('userid');
            $id = $request->get('id');

            if ($userid != '' && $reference_code != '') {
                $post->where('tblwidtraw.fkuserid', '=', $request->get('userid'));
            }

            if ($userid == '' && $reference_code != '') {
                $post->where('users.referrercode', $reference_code);
            }

            if ($id != '') {
                $post->where('tblwidtraw.withdrawid', '=', $id);
            }

            $post
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

    public function updateStatus(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $id = $request->get('id');

        $status = $request->get('status');

        $withdraw = Withdrawal::where('withdrawid', $id)->first();

        if ($withdraw->status != 'pending') {
            return response()->json([
                'message' => 'Your transaction was not accepted'
            ], 422);
        }

        if ($withdraw != null) {

            Withdrawal::where('withdrawid', $id)
                ->update([
                    'confirmuserid' => AuthManager::getAuthId(),
                    'status' => $request->get('status'),
                    'confirmtime' => AuthManager::get_time(),
                    'confirmdate' => AuthManager::get_date(),
                ]);

            if ($status == 'reject') {
                if ($withdraw->fkwalletid > 0) {

                    Wallet::where('walletid', $withdraw->fkwalletid)
                        ->increment('balance', $withdraw->balance);
                }

                if ($withdraw->fkwalletid == null || $withdraw->fkwalletid == '') {

                    User::where('id', $withdraw->fkuserid)
                        ->increment('walletamount', $withdraw->balance);
                }

                if ($status == 'reject') {
                    return response()->json([
                        'message' => 'reject successfully'
                    ], 201);
                }
            }
        }

        return response()->json([
            'message' => 'Confirm successfully'
        ], 201);
    }
}
