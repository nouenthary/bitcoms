<?php

namespace App\Http\Controllers;

use App\Services\DepositService;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    private $depositService;

    public function __construct(DepositService $depositService)
    {
        // require login
        $this->middleware('auth');
        $this->depositService = $depositService;
    }

    public function deposit_page()
    {
        return view('deposit.index');
    }

    public function index(Request $request)
    {
        return $this->depositService->getDeposits($request);
    }

    public function store(Request $request)
    {
        return $this->depositService->createDeposit($request);
    }

    public function update(Request $request)
    {
        return $this->depositService->updateDeposit($request);
    }

    public function confirm(Request $request)
    {
        return $this->depositService->confirmWallet($request);
    }

    public function show(Request $request)
    {
        return $this->depositService->getDepositId($request);
    }

    public function delete(Request $request)
    {
        return $this->depositService->deleteDeposit($request);
    }
}
