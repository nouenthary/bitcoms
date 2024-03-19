<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WithdrawConfirmationService;
use Illuminate\Http\Request;

class WithdrawConfirmationController extends Controller
{
    private $withdrawConfirmationService;

    public function __construct(WithdrawConfirmationService $withdrawConfirmationService)
    {
        $this->middleware('auth');
        $this->withdrawConfirmationService = $withdrawConfirmationService;
    }

    public function count_withdraw_confirmations(Request $request)
    {
        return $this->withdrawConfirmationService->countWithdraw();
    }

    public function get_withdraw_confirmations(Request $request)
    {
        return $this->withdrawConfirmationService->getWithdraws($request);
    }

    public function post_withdraw_confirmation(Request $request)
    {
        return $this->withdrawConfirmationService->updateStatus($request);
    }
}
