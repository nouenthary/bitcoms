<?php

namespace App\Services;

use App\Auth\AuthManager;
use App\Models\Deposit;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 * Class DepositConfirmationService
 * @package App\Services
 */
class DepositConfirmationService
{
    public function countDeposits()
    {
        return Deposit::where('status', 'like', 'pending')->count();
    }

    public function getDeposits(Request $request)
    {
        if ($request->ajax()) {

            $post = Deposit::join('users', 'tbldeposit.fkuserid', '=', 'users.id')
                ->join('tblwallet', 'tblwallet.walletid', '=', 'tbldeposit.fkwalletid')
                ->join('tblwallettitle', 'tblwallet.fkwallettileid', '=', 'tblwallettitle.walletid')
                ->select(
                    'tblwallettitle.namecurencywallet',
                    'tblwallettitle.namecurency',
                    'tblwallettitle.imagecurency',

                    'tbldeposit.*',

                    'users.name',
                    'users.image',

                    DB::raw("(select name from users where id = tbldeposit.userconfirmid)  as user_confirm"),
                    DB::raw("(select image from users where id = tbldeposit.userconfirmid)  as image_confirm"),
                );

            if ($request->get('status') != '') {
                $post->where('tbldeposit.status', 'like', $request->get('status'));
            }

            if ($request->get('userid') != '') {
                $post->where('tbldeposit.fkuserid', '=', $request->get('userid'));
            }

            if ($request->get('id') != '') {
                $post->where('tbldeposit.depositid', '=', $request->get('id'));
            }

            $reference_code = $request->get('reference_code');
            $userid = $request->get('userid');
            $id = $request->get('id');

            if ($userid != '' && $reference_code != '') {
                $post->where('tbldeposit.fkuserid', '=', $request->get('userid'));
            }

            if ($userid == '' && $reference_code != '') {
                $post->where('users.referrercode', $reference_code);
            }


            $post->get();

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

        $deposit = Deposit::where('depositid', $id)->first();

        if ($deposit->status != 'pending') {
            return response()->json([
                'message' => 'updated successfully'
            ], 201);
        }

        if ($deposit != null) {
            Deposit::where('depositid', $id)
                ->update([
                    'userconfirmid' => AuthManager::getAuthId(),
                    'status' => $request->get('status'),
                    'confirmtime' => AuthManager::get_time(),
                    'confirmdate' => AuthManager::get_date(),
                ]);

            if ($status != 'reject') {
                Wallet::where('walletid', $deposit->fkwalletid)
                    ->increment('balance', $deposit->amout);

                return response()->json([
                    'message' => 'reject successfully'
                ], 201);
            }
        }

        return response()->json([
            'message' => 'updated successfully'
        ], 201);
    }
}
