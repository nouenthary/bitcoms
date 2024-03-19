<?php


namespace App\Services;

use App\Auth\AuthManager;
use App\Models\TransferCoin;
use App\Models\Wallet;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransferCoinService
{

    public function page_admin()
    {
        if (AuthManager::isAdmin() == false) {
            return view('error.error');
        }

        return view('transfer_coin_setting.index');
    }

    public function getTransferCoin(Request $request)
    {
        if ($request->ajax()) {

            $post = TransferCoin::leftJoin('tblwallet', 'tblcointranfer.fkwalletid', '=', 'tblwallet.walletid')
                ->join('tblwallettitle', 'tblwallet.fkwallettileid', '=', 'tblwallettitle.walletid')
                ->join('users', 'users.id', '=', 'tblcointranfer.fkuserid')
                ->select(
                    'tblcointranfer.*',
                    'tblcointranfer.dateupdate as start_date',
                    'tblcointranfer.timeupdate as start_time',
                    'tblwallettitle.*',
                    'users.name',
                    'users.image',
                    'users.backimage',
                    'users.frontimage',
                );

            if ($request->get('start_date') != '') {
                $post->whereDate('tblcointranfer.dateupdate', '>=', $request->get('start_date'));
            }

            if ($request->get('end_date') != '') {
                $post->whereDate('tblcointranfer.dateupdate', '<=', $request->get('end_date'));
            }

            if ($request->get('fkwalletid') != '') {
                $post->where('tblwallet.walletid', $request->get('fkwalletid'));
            }

            if (AuthManager::isAdmin() == false) {
                $post->where('tblcointranfer.fkuserid', AuthManager::getAuthId());
            }

            if ($request->get('userid') != '') {
                $post->where('tblcointranfer.fkuserid', $request->get('userid'));
            }

            //
            if ($request->get('wallet_title_id') != '') {
                $post->where('tblwallettitle.walletid', $request->get('wallet_title_id'));
            }

            $post
                ->get();

            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->walletid;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json([
            'message' => 'data retrieved successfully'
        ], 200);
    }

    public function createTransferCoin(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'tranfercoinid' => 'required',
            'fkuserid' => 'required',
            'fkwalletid' => 'required',
            'fromwalletname' => 'required',
            'towalletname' => 'required',
            'logofromwallet' => 'required',
            'logotowallet' => 'required',
            'amount' => 'required|numeric|gt:0',
            //'timeupdate' => 'required',
            //'dateupdate' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        $walletid = $request->get('fkwalletid');

        $wallet = Wallet::where('walletid', $walletid)->first();

        if ($wallet == null || $wallet == '') {
            return response()->json(['message' => 'wallet is not available', 'status' => false], 422);
        }

        $balance = $request->get('balance');

        $amount = $request->get('amount');

        if ($balance > $wallet->balance) {
            return response()->json(['message' => 'wallet is available ' . $wallet->balance, 'status' => false], 422);
        }

        if ($balance == $wallet->balance) {
            Wallet::where('walletid', $walletid)->update([
                'balance' => 0
            ]);

            TransferCoin::create([
                'tranfercoinid' => $request->get('tranfercoinid'),
                'fkuserid' => AuthManager::getAuthId(),
                'fkwalletid' => $request->get('fkwalletid'),
                'fromwalletname' => $request->get('fromwalletname'),
                'towalletname' => $request->get('towalletname'),
                'logofromwallet' => $request->get('logofromwallet'),
                'logotowallet' => $request->get('logotowallet'),
                'amount' => $request->get('amount'),
                'timeupdate' => AuthManager::get_time(),
                'dateupdate' => AuthManager::get_date(),
                'amount_transfer' => $request->get('balance'),
                'exchange_price' => $request->get('exchange_price'),
            ]);

            $user = UserModel::where('id', AuthManager::getAuthId())->first();

            UserModel::where('id', AuthManager::getAuthId())->update([
                'walletamount' => $amount + $user->walletamount
            ]);

            return response()->json([
                'message' => 'created successfully'
            ], 201);
        }
        return response()->json(['message' => 'wallet is available ' . $wallet->balance, 'status' => false], 422);
    }
}
