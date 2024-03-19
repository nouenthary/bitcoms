<?php


namespace App\Services;


use App\Auth\AuthManager;
use App\Models\Deposit;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\Upload;
use Yajra\DataTables\DataTables;


/**
 * Class DepositService
 * @package App\Services
 */
class DepositService
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getDeposits(Request $request)
    {
        if ($request->get('option') == 'select') {

            $page = $request->get('page', 1);
            $size = $request->get('size', 10);
            $deposit_id = $request->get('deposit_id', '');
            $name = $request->get('name', '');
            $address = $request->get('address', '');
            $voucher = $request->get('voucher', '');
            $status = $request->get('status', '');
            $user_id = $request->get('user_id', '');
            $wallet_id = $request->get('wallet_id', '');
            $create_date = $request->get('create_date', '');
            $create_time = $request->get('create_time', '');
            $column = $request->get('column', 'walletid');
            $order = $request->get('order', 'asc');

            $data = Deposit::join('users', 'tbldeposit.fkuserid', '=', 'users.id')
                ->join('tblwallet', 'tblwallet.walletid', '=', 'tbldeposit.fkwalletid')
                ->select(
                    'tbldeposit.*',

                    'tblwallet.balance',
                    'tblwallet.createtime as wallet_createtime',
                    'tblwallet.createdate as wallet_createdate',

                    'users.name',
                    'users.image',       
                );

            if (AuthManager::isAdmin() == false) {
                $data = $data->where('tbldeposit.fkuserid', AuthManager::getAuthId());
            }

            if ($wallet_id != '') {
                $data = $data->where('tbldeposit.walletid', $wallet_id);
            }

            if ($user_id != '') {
                $data = $data->where('tbldeposit.fkuserid', $user_id);
            }

            if ($deposit_id != '') {
                $data = $data->where('tbldeposit.depositid', $deposit_id);
            }

            if ($name != '') {
                $data = $data->where('tbldeposit.namewallet', $name);
            }

            if ($status != '') {
                $data = $data->where('tbldeposit.status', $status);
            }

            if ($address != '') {
                $data = $data->where('tbldeposit.walletaddr', $address);
            }

            if ($name != '') {
                $data = $data->where('tbldeposit.namewallet', $name);
            }

            if ($voucher != '') {
                $data = $data->where('tbldeposit.paymnentvoucher', $voucher);
            }

            if ($create_date != '') {
                $data = $data->whereDate('tbldeposit.createdate', $create_date);
            }

            if ($create_time != '') {
                $data = $data->whereDate('tbldeposit.createdate', $create_time);
            }

            $data = $data
                ->orderBy($column, $order)
                ->paginate($size, ['*'], 'page', $page);

            return response()->json($data);
        }

        if ($request->ajax()) {
            $post = Deposit::join('users', 'tbldeposit.fkuserid', '=', 'users.id')
                ->join('tblwallet', 'tblwallet.walletid', '=', 'tbldeposit.fkwalletid')
                ->join('tblwallettitle', 'tblwallet.fkwallettileid', '=', 'tblwallettitle.walletid')
                ->select(
                    'tblwallettitle.namecurencywallet',
                    'tblwallettitle.namecurency',
                    'tblwallettitle.imagecurency',
                    'tbldeposit.*',

                    'tblwallet.balance',
                    'tblwallet.createtime as wallet_createtime',
                    'tblwallet.createdate as wallet_createdate',

                    'users.name',               
                    'users.image',               
                );

            if ($request->get('status') != '') {
                $post->where('tbldeposit.status', $request->get('status'));
            }

            if ($request->get('wallet_title_id') != '') {
                $post->where('tblwallettitle.walletid', $request->get('wallet_title_id'));
            }

            if ($request->get('start_date') != '') {
                $post->whereDate('tbldeposit.dateupdate', '>=', $request->get('start_date'));
            }

            if ($request->get('end_date') != '') {
                $post->whereDate('tbldeposit.dateupdate', '<=', $request->get('end_date'));
            }

            if (AuthManager::isAdmin() == false) {
                $post->where('tbldeposit.fkuserid', AuthManager::getAuthId());
            }

            $post->get();

            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = 0;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data' => []
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDepositId(Request $request)
    {
        $id = $request->get('depositid');

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        $data = Deposit::where('depositid', $id)->first();

        return response()->json([
            'data' => $data,
        ]);
    }

    use Upload;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createDeposit(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'depositid' => 'required',
            'fkuserid' => 'required',
            'fkwalletid' => 'required',
            'namewallet' => 'required',
            'qrimage' => 'required',
            'walletaddr' => 'required',
            'amount' => 'required',
            'paymentvoucher' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            //return response()->json(['message' => 'Please contact to admin ...', 'status' => false ], 422);
        }

        $payment_voucher  = $this->UploadFileVoucher($request, 'payment_voucher');

        // if ($request->hasFile('file')) {
        //     $payment_voucher = $this->UploadFile($request->file('paymentvoucher'), 'payment_voucher');
        // }
        //  return $payment_voucher;

        Deposit::create([
            'depositid' => 0,
            'fkuserid' => AuthManager::getAuthId(),
            'fkwalletid' => $request->get('fkwalletid'),
            'namewallet' => $request->get('namewallet'),
            'qrimage' => $request->get('qrimage'),
            'walletaddr' => $request->get('walletaddr'),
            'amout' => $request->get('amount'),
            'paymentvoucher' => $payment_voucher,
            'status' => $request->get('status'),
            'timeupdate' => AuthManager::get_time(),
            'dateupdate' => AuthManager::get_date(),
            'userconfirmid' => null,
            'confirmtime' => null,
            'confirmdate' => null
        ]);

        return response()->json([
            'message' => 'created successfully'
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateDeposit(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'depositid' => 'required',
            'fkuserid' => 'required',
            'fkwalletid' => 'required',
            'namewallet' => 'required',
            'qrimage' => 'required',
            'walletaddr' => 'required',
            'amount' => 'required',
            'paymentvoucher' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $id = $request->get('depositid');

        if ($id > 0) {

            Deposit::where('depositid', $id)
                ->update([
                    //'fkuserid' => AuthManager::getAuthId(),
                    'fkwalletid' => $request->get('fkwalletid'),
                    'namewallet' => $request->get('namewallet'),
                    'qrimage' => $request->get('qrimage'),
                    'walletaddr' => $request->get('walletaddr'),
                    'amount' => $request->get('amount'),
                    'paymentvoucher' => $request->get('paymentvoucher'),
                    'status' => $request->get('status'),
                    'timeupdate' => AuthManager::get_date_time(),
                    'dateupdate' => AuthManager::get_date_time(),
                ]);
        }

        return response()->json([
            'message' => 'updated successfully'
        ], 201);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmWallet(Request $request)
    {
        $id = $request->get('depositid');

        $validatedData = Validator::make($request->all(), [
            'depositid' => 'required',
            'userconfirmid' => 'required',
            'confirmtime' => 'required',
            'confirmdate' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $deposit = Deposit::where('depositid', $id)->first();

        if ($deposit->status == 'pending') {
            $wallet = Wallet::where('walletid', $deposit->fkwalletid)->first();
            if ($wallet != '' || $wallet != null) {
                Wallet::where('walletid', $deposit->fkwalletid)->update([
                    'balance' => $deposit->amout + $wallet->balance
                ]);
            }

            Deposit::where('depositid', $id)
                ->update([
                    'userconfirmid' => AuthManager::getAuthId(),
                    'confirmtime' => AuthManager::get_time(),
                    'confirmdate' => AuthManager::get_date(),
                    'status' => 'done'
                ]);
        }

        return response()->json([
            'message' => 'updated successfully'
        ], 201);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteDeposit(Request $request)
    {
        $id = $request->get('depositid');

        $wallet_id = $request->get('fkwalletid');

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $wallet = Wallet::where('fkwalletid', $wallet_id)->first();

        if ($wallet == '') {
            return response()->json(['message' => 'wallet is not available ...', 'status' => false], 422);
        }

        if ($wallet != '') {

            $deposit = Deposit::where('depositid', $id)->first();

            $amount = $deposit->amount;

            if ($wallet->balance < $amount) {
                return response()->json(['message' => 'wallet is not available ...', 'status' => false], 422);
            }

            $wallet->balance += $amount;
            $wallet->save();
        }

        if ($id > 0) {
            Deposit::where('depositid', $id)->delete();
        }

        return response()->json([
            'message' => 'deleted successfully'
        ], 201);
    }
}
