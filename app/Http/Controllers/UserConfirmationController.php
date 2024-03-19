<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserConfirmationService;
use Illuminate\Http\Request;

class UserConfirmationController extends Controller
{
    private $userConfirmationService;

    public function __construct(UserConfirmationService $userConfirmationService)
    {
        $this->middleware('auth');
        $this->userConfirmationService = $userConfirmationService;
    }

    public function get_user_confirmations(Request $request)
    {
        return $this->userConfirmationService->getUsers($request);
    }

    public function count_user_confirmations(Request $request)
    {
        return $this->userConfirmationService->countUsers($request);
    }

    public function post_user_confirmation(Request $request)
    {
        return  $this->userConfirmationService->confrimStatus($request);
    }
}
