<?php

namespace App\Http\Controllers;

use App\Auth\AuthManager;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    //
    public function get_users(Request $request)
    {
        $users = User::select(
            'id',
            'name',
            'image',
            'invitationcode as code'
        )->where('id', '>', 0);

        if (AuthManager::isAdmin() == false) {
            $code = auth()->user()->invitationcode;

            $users->where('users.referrercode', $code);
        }

        if ($request->get('name') != '') {
            $users = $users
                ->where('name', 'LIKE', '%' . $request->get('name') . '%')
                ->orWhere('invitationcode', 'LIKE', '%' . $request->get('name') . '%');
        }
        return $users
            ->take(20)
            ->get();
    }
    //
    public function get_fee()
    {
        $fee = DB::table('tblfee')->first();

        if ($fee == null) {
            return 0;
        }

        return $fee->tradeffeepercent;
    }
    //
    public function get_user_trade()
    {
        $authId = AuthManager::getAuthId();
        $model = DB::table('tbltradetitle')->where('fkuserid', $authId)->first();

        if ($model == null) {
            return 0;
        }

        return $model->wintrade;
    }
    //
    public function get_user_wallet()
    {
        $authId = AuthManager::getAuthId();
        $model = DB::table('users')->where('id', $authId)->first();

        if ($model == null) {
            return 0;
        }

        return $model->walletamount;
    }
    //
    public function get_wallet_title(Request $request)
    {
        $data = DB::table('tblwallettitle')
            ->select(
                'walletid as id',
                'namecurencywallet as name',
                'imagecurency as image',
                'namecurency as code'
            )
            ->where('walletid', '>', 0);

        if ($request->get('name') != '') {
            $data = $data
                ->where('namecurencywallet', 'LIKE', '%' . $request->get('name') . '%')
                ->orWhere('namecurency', 'LIKE', '%' . $request->get('name') . '%');
        }
        return $data
            ->take(20)
            ->get();
    }
}
