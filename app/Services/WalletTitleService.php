<?php


namespace App\Services;

use App\Auth\AuthManager;
use App\Models\WalletTitle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Traits\Upload;


/**
 * Class WalletTitleService
 * @package App\Services
 */
class WalletTitleService
{
    public function viewPage()
    {
        if (AuthManager::isAdmin() == false) {
            return view('error.error');
        }
        return view('wallet_title.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getWalletTitles(Request $request)
    {
        if ($request->get('option') == 'select') {
            $page = $request->get('page', 1);
            $size = $request->get('size', 10);
            $id = $request->get('id', '');
            $name = $request->get('name', '');
            $currency = $request->get('currency', '');
            $column = $request->get('column', 'walletid');
            $order = $request->get('order', 'asc');

            if (AuthManager::isAdmin() == false) {
                // return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
            }

            $data = WalletTitle::select('*');

            if ($id != '') {
                $data = $data->where('walletid', $id);
            }

            if ($name != '') {
                $data = $data->where('namecurencywallet', $name);
            }

            if ($currency != '') {
                $data = $data->where('namecurency', $currency);
            }

            $data = $data->orderBy($column, $order)->paginate($size, ['*'], 'page', $page);

            return response()->json($data);
        }

        if ($request->ajax()) {

            $post = WalletTitle::get();
            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->walletid;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getWalletTitleId($id)
    {
        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $data = WalletTitle::where('walletid', $id)->first();

        return response()->json([
            'data' => $data,
            'status' => true
        ]);
    }

    use Upload;


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createWalletTitle(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'namecurencywallet' => 'required|unique:tblwallettitle',
            'namecurency' => 'required|unique:tblwallettitle',
            'walletaddress' => 'required|unique:tblwallettitle',
            'qrimage' => 'mimes:jpeg,jpg,png,gif|required',
            'imagecurency' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $qrimage = $this->UploadFileImage($request, 'wallet_title');

        WalletTitle::create([
            'walletid' => 0,
            'namecurencywallet' => $request->get('namecurencywallet'),
            'namecurency' => $request->get('namecurency'),
            'walletaddress' => $request->get('walletaddress'),
            'qrimage' => $qrimage,
            'imagecurency' => $request->get('imagecurency'),
            'timeupdate' => AuthManager::get_time(),
            'dateupdate' => AuthManager::get_date(),
        ]);

        return response()->json([
            'message' => 'created successfully',
            'status' => true
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateWalletTitle(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'walletid' => 'required',
            'namecurencywallet' => 'required|unique:tblwallettitle,namecurencywallet,' . $request->get('walletid') . ',walletid',
            'namecurency' => 'required|unique:tblwallettitle,namecurency,' . $request->get('walletid') . ',walletid',
            'walletaddress' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        $qrimage = $this->UploadFileImage($request, 'wallet_title');

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        $id = $request->get('walletid');

        if ($id > 0) {

            $model = [
                'namecurencywallet' => $request->get('namecurencywallet'),
                'namecurency' => $request->get('namecurency'),
                'walletaddress' => $request->get('walletaddress'),
                //'qrimage' => $qrimage,
                'imagecurency' => $request->get('imagecurency'),
                'timeupdate' => AuthManager::get_time(),
                'dateupdate' => AuthManager::get_date(),
            ];

            if ($qrimage != '') {
                $model['qrimage'] = $qrimage;
            }

            WalletTitle::where('walletid', $request->get('walletid'))->update($model);
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
    public function deleteWalletTitle(Request $request)
    {
        $id = $request->get('walletid');

        if (AuthManager::isAdmin() == false) {
            return response()->json(['message' => 'Please contact to admin ...', 'status' => false], 422);
        }

        if ($id > 0) {
            WalletTitle::where('walletid', $id)->delete();
        }

        return response()->json([
            'message' => 'deleted successfully',
            'status' => true
        ], 201);
    }
}
