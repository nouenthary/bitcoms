<?php


namespace App\Services;


use App\Auth\AuthManager;
use App\Models\Fee;
use App\Models\UserModel;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class WalletService
 * @package App\Services
 */
class WalletService
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getWallets(Request $request)
    {
        $page = $request->get('page', 1);
        $size = $request->get('size', 100);
        $wallet_id = $request->get('wallet_id', '');
        $user_id = $request->get('user_id', '');
        $wallet_title_id = $request->get('wallet_title_id', '');
        $balance = $request->get('balance', '');
        $create_date = $request->get('create_date', '');
        $create_time = $request->get('create_time', '');
        $column = $request->get('column', 'walletid');
        $order = $request->get('order', 'asc');

        $data = Wallet::join('users', 'tblwallet.fkuserid', '=', 'users.id')
            ->join('tblwallettitle', 'tblwallet.fkwallettileid', '=', 'tblwallettitle.walletid')
            ->select(
                'tblwallet.*',

                'tblwallettitle.namecurencywallet',
                'tblwallettitle.namecurency',
                'tblwallettitle.walletaddress',
                'tblwallettitle.qrimage',
                'tblwallettitle.imagecurency',

                'users.name',
                'users.accnumber',
                'users.image',
                'users.sex',
                'users.address',
                'users.city',
                'users.city',
                'users.country',
                'users.email',
                'users.status',
                'users.phone',
                'users.idcard',
                'users.idname',
                'users.frontimage',
                'users.backimage',
                'users.dob',
                'users.walletamount'
            );

        $data = $data->where('tblwallet.fkuserid', AuthManager::getAuthId());

        if ($wallet_id != '') {
            $data = $data->where('tblwallet.walletid', $wallet_id);
        }

        if ($user_id != '') {
            $data = $data->where('tblwallet.fkuserid', $user_id);
        }

        if ($wallet_title_id != '') {
            $data = $data->where('tblwallet.fkwallettileid', $wallet_title_id);
        }

        if ($balance != '') {
            $data = $data->where('tblwallet.balance', $balance);
        }

        if ($create_date != '') {
            $data = $data->whereDate('tblwallet.createdate', $create_date);
        }

        if ($create_time != '') {
            $data = $data->whereDate('tblwallet.createdate', $create_time);
        }

        $data = $data
            ->orderBy($column, $order)
            ->paginate($size, ['*'], 'page', $page);

        // get fee
        $fee = Fee::first();
        if ($fee == '') {
            $fee = [
                'feeid' => '0',
                'tradeffeepercent' => '0',
                'widtrwfeepercent' => '0',
                'timeupdate' => date('Y-m-d H:i:s'),
                'dateupdate' => date('Y-m-d H:i:s')
            ];
        }
        //
        // get use
        $user = UserModel::where('id', AuthManager::getAuthId())->first();
        //

        return response()->json([
            'fee' => $fee,
            'user' => $user,
            'data' => $data->items(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getWalletId(Request $request)
    {
        $id = $request->get('walletid');

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        $data = Wallet::where('walletid', $id)->first();

        return response()->json([
            'data' => $data,
            'status' => true
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createWallet(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'fkwallettileid' => 'required',
            'balance' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        $count = DB::table('tblwallet')
            ->where('fkuserid', AuthManager::getAuthId())
            ->where('fkwallettileid', $request->get('fkwallettileid'))
            ->count();

        if ($count > 0) {
            return response()->json(['message' => 'You can wallet because is exist...', 'status' => false], 422);
        }

        if ($count == 0) {
            Wallet::create([
                'walletid' => 0,
                'fkuserid' => AuthManager::getAuthId(),
                'fkwallettileid' => $request->get('fkwallettileid'),
                'balance' => $request->get('balance'),
                'createtime' => AuthManager::get_time(),
                'createdate' => AuthManager::get_date(),
                //'codeaddres' => null,
                //'codelink' => null
            ]);
        }

        return response()->json([
            'message' => 'created successfully',
            'status' => true
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateWallet(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'walletid' => 'required',
            'fkwallettileid' => 'required',
            'balance' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        $id = $request->get('walletid');

        $count = DB::table('tblwallet')
            ->where('walletid', '!=', $id)
            ->where('fkuserid', AuthManager::getAuthId())
            ->where('fkwallettileid', $request->get('fkwallettileid'))
            ->count();

        if ($count > 0) {
            return response()->json(['message' => 'You can wallet because is exist...', 'status' => false], 422);
        }

        if ($id > 0) {
            Wallet::where('walletid', $request->get('walletid'))
                ->update([
                    'fkuserid' => AuthManager::getAuthId(),
                    'fkwallettileid' => $request->get('fkwallettileid'),
                    'balance' => $request->get('balance'),
                    'createtime' => AuthManager::get_time(),
                    'createdate' => AuthManager::get_date(),
                ]);
        }

        return response()->json([
            'message' => 'updated successfully',
            'status' => true
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteWallet(Request $request)
    {
        $id = $request->get('walletid');

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        if ($id > 0) {
            Wallet::where('walletid', $id)->delete();
        }

        return response()->json([
            'message' => 'deleted successfully',
            'status' => true
        ], 201);
    }
}
