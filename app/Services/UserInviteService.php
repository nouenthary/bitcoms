<?php

namespace App\Services;


use App\Auth\AuthManager;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserInviteService
{
    public function viewPageUserInvite()
    {
        $permission = AuthManager::isAdmin();
        return view('user_invite.index', compact('permission'));
    }

    public function viewPageUserInvitAdmin()
    {
        $permission = AuthManager::isAdmin();

        if (AuthManager::isAdmin() == false) {
            return view('error.error');
        }
        return view('user_invite.index', compact('permission'));
    }

    public function getAllUsers(Request $request)
    {
        if ($request->ajax()) {

            $post = User::where('id', '>', 0);

            $userid = $request->get('userid');

            $referrercode = $request->get('referrercode');

            if (AuthManager::isAdmin() == false) {

                $ownerCode = auth()->user()->invitationcode;

                $post->where('users.referrercode', $ownerCode);

                if ($userid != '') {
                    $post->where('users.id', $userid);
                }
            }

            if (AuthManager::isAdmin() == true) {

                if ($userid != '' && $referrercode != '') {
                    $post->where('users.id', $userid);
                }

                if ($userid == '' && $referrercode != '') {
                    $post->where('users.referrercode', $referrercode);
                }
            }

            $post->get();

            return Datatables::of($post)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return $id;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json([
            'message' => 'data retrieved successfully'
        ], 200);
    }
}
