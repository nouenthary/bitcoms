<?php

namespace App\Http\Controllers;

use App\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $fee = DB::table('tblfee')->first();
            if ($fee == '') {
                DB::table('tblfee')->insert([
                    'feeid' => '0',
                    'tradeffeepercent' => '10',
                    'widtrwfeepercent' => '10',
                    'timeupdate' => date('Y-m-d H:i:s'),
                    'dateupdate' => date('Y-m-d H:i:s')
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ])->onlyInput('name');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function login_page()
    {
        return view('auth/login');
    }

    public function register_page()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        //return $request->all();
        // DB::table('users')
        //     ->insert([
        //         'name' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('admin'),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);
        // die();

        $path = public_path() . "/profile/";
        if ($request->file != '') {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
            $path = '/profile/' . $filename;
        }
        //return $path;

        $isUser = $request->get('is_user') == 'on' ? 1 : 0;
        $idAdmin = $request->get('id_admin') == 'on' ? 1 : 0;

        $username = $request->get('name');
        $password = $request->get('password');

        $user = DB::table('users')->where('name', $username)->first();

        if ($user != '') {
            return redirect()->intended('/login-page');
        }

        $id = DB::table('users')->insertGetId([
            'id' => 0,
            'name' => $username,
            'password' => Hash::make($password),
            // 'accnumber' => 1,
            // 'verificode' => 1,
            'phone' => '077 77 26 55',
            'invitationcode' => '111111',
            // 'idcard' => 1,
            // 'uderconfirmid' => 1,
            'image' => $path,
            'sex' => 'male',
            'address' => 'phnom penh',
            'city' => 'phnom penh',
            'country' => 'cambodia',
            'email' => $username . '@example.com',
            'status' => 'pending',
            // 'invitationlink' => 'http://example.com',
            'referrercode' => '111111',
            // 'idname' => 'admin',
            'frontimage' => $path,
            'backimage' => $path,
            // 'dob' => 'http://example',
            // 'Longtitude' => '1',
            // 'Latitude' => '1',
            // 'Browser' => 'http://example',
            // 'isp' => 'http://example',
            // 'ip' => 'http://example',
            'timeupdate' => AuthManager::get_time(),
            'dateupdate' => AuthManager::get_date(),
            // 'confirmtime' => 'http',
            // 'confirmdate' => 'd',
            'walletamount' => 100,
            // 'userlogin' => 'true',
            // 'codeaddress' => '',
            // 'codelink' => ''
        ]);

        DB::table('tblpermission')->insert([
            'permissionid' => 0,
            'fkuserid' => $id,
            'normal' => $isUser,
            'admin' => $idAdmin,
            'timeupdate' => date('H:i:s'),
            'dateupdate' => date('Y-m-d')
        ]);

        DB::table('tbltradetitle')->insert([
            'tradetitleid' => 0,
            'fkuserid' => $id,
            'wintrade' => 'win',
            'timeupdate' => date('H:i:s'),
            'dateupdate' => date('Y-m-d')
        ]);

        $credentials = [
            'name' => $username,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect('/login-page')->with('success', '');
    }
}
