<?php


namespace App\Services;


use App\Auth\AuthManager;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/**
 * Class TradeService
 * @package App\Services
 */
class TradeService
{
    public function viewPage()
    {
        return view('trade.index');
    }

    public function viewPageTransaction()
    {
        $permission = AuthManager::isAdmin();
        return view('trade.trade_transaction', compact('permission'));
    }
public function viewPageTransactionAdmin()
    {
        $permission = AuthManager::isAdmin();
        
        if (AuthManager::isAdmin() == false) {
            return view('error.error');
        }
        return view('trade.trade_transaction', compact('permission'));
    }

    public function getAllTrade(Request $request)
    {
        if ($request->ajax()) {

            $post = Trade::join('users', 'users.id', '=', 'tbltrde.fkuserid')
                ->select(
                    'tbltrde.*',
                    'users.name',
                    'users.image',
                    'users.backimage',
                    'users.frontimage',
                );

            if ($request->get('start_date') != '') {
                $post->whereDate('tbltrde.dateupdate', '>=', $request->get('start_date'));
            }

            if ($request->get('end_date') != '') {
                $post->whereDate('tbltrde.dateupdate', '<=', $request->get('end_date'));
            }

            if ($request->get('status') != '') {
                $post->where('tbltrde.status', $request->get('status'));
            }

            if ($request->get('tradetitle') != '') {
                $post->where('tbltrde.tradetitle', $request->get('tradetitle'));
            }

            if ($request->get('wintrade') != '') {
                $post->where('tbltrde.wintrade', $request->get('wintrade'));
            }

            if (AuthManager::isAdmin() == false) {
                //$ownerCode = auth()->user()->invitationcode;
                //$post->where('users.referrercode', $ownerCode);

                if ($request->get('user') == true) {
                    $post->where('tbltrde.fkuserid', AuthManager::getAuthId());
                }
            }

            $userid = $request->get('userid');

            $referrercode = $request->get('referrercode');

            if ($userid != '' && $referrercode != '') {
                $post->where('tbltrde.fkuserid', $userid);
            }

            if ($userid == '' && $referrercode != '') {
                $post->where('users.referrercode', $referrercode);
            }


            $post->get();

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

    public function createTrade(Request $request)
    {
        $amount = $request->get('amount');
        $user = DB::table('users')->where('id', AuthManager::getAuthId())->first();
        //return $user->walletamount;

        if ($amount > $user->walletamount) {
            return response()->json(['message' => 'Your balance ' . $user->walletamount, 'status' => false], 422);
        }

        $validatedData = Validator::make($request->all(), [
            'tradeid' => 'required',
            'fkuserid' => 'required',
            'feepercent' => 'required|numeric|gt:0',
            'feeamount' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
            'totalamount' => 'required|numeric|gt:0',
            'namecurrency' => 'required',
            'wintrade' => 'required',
            'lastprice' => 'required|numeric|gt:0',
            'logocurrency' => 'required',
            'timeupdate' => 'required',
            'dateupdate' => 'required',
            'timetrade' => 'required',
            'tradetitle' => 'required',
            'status' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->messages(), 'status' => false], 422);
        }

        if ($amount > 0) {

            Trade::create([
                'tradeid' => $request->get('tradeid'),
                'fkuserid' => AuthManager::getAuthId(),
                'feepercent' => $request->get('feepercent'),
                'feeamount' => $request->get('feeamount'),
                'amount' => $request->get('amount'),
                'totalamount' => $request->get('totalamount'),
                'namecurrency' => $request->get('namecurrency'),
                'wintrade' => $request->get('wintrade'),
                'lastprice' => $request->get('lastprice'),
                'logocurrency' => $request->get('logocurrency'),
                'timeupdate' => AuthManager::get_time(),
                'dateupdate' => AuthManager::get_date(),
                'timetrade' => $request->get('timetrade'),
                'tradetitle' => $request->get('tradetitle'),
                'status' => $request->get('status'),
            ]);

            // update balance user wallet amount
            $winDrade = $request->get('wintrade');

            if ($winDrade == "win") {
                DB::table('users')
                    ->where('id', AuthManager::getAuthId())
                    ->update([
                        'walletamount' => $user->walletamount + $request->get('totalamount')
                    ]);
            } else if ($winDrade == "lose") {
                DB::table('users')
                    ->where('id', AuthManager::getAuthId())
                    ->update([
                        'walletamount' => $user->walletamount - $request->get('amount')
                    ]);
            }
            //
            return response()->json([
                'message' => 'created successfully'
            ], 201);
        }
        return response()->json(['message' => 'wallet is available ' . $amount, 'status' => false], 422);
    }
}
