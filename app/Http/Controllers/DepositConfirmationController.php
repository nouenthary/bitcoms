<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DepositConfirmationService;
use Illuminate\Http\Request;

class DepositConfirmationController extends Controller
{
    private $depositConfirmationService;

    public function __construct(DepositConfirmationService $depositConfirmationService)
    {
        $this->middleware('auth');
        $this->depositConfirmationService = $depositConfirmationService;
    }

    public function count_deposit_confirmations()
    {
        return $this->depositConfirmationService->countDeposits();
    }

    public function get_deposit_confirmations(Request $request)
    {
        return $this->depositConfirmationService->getDeposits($request);
    }

    public function post_deposit_confirmation(Request $request)
    {
        return $this->depositConfirmationService->updateStatus($request);
    }
}
