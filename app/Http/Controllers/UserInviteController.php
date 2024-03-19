<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserInviteService;
use Illuminate\Http\Request;

class UserInviteController extends Controller
{
    private $userInviteService;

    public function __construct(UserInviteService $userInviteService)
    {
        // require login
        $this->middleware('auth');
        $this->userInviteService = $userInviteService;
    }

    public function index(Request $request)
    {
        return $this->userInviteService->getAllUsers($request);
    }

    public function page_user_invite()
    {
        return $this->userInviteService->viewPageUserInvite();
    }

    public function page_user_invite_admin()
    {
        return $this->userInviteService->viewPageUserInvitAdmin();
    }
}
