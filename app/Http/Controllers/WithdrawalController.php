<?php

namespace App\Http\Controllers;

use App\Services\WithdrawalService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    private $withdrawalService;

    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->middleware('auth');
        $this->withdrawalService = $withdrawalService;
    }

    public function page()
    {
        return view('withdrawal.index');
    }

    public function index(Request $request)
    {
       return $this->withdrawalService->getWithdrawal($request);
    }

    public function show(Request $request)
    {
       return $this->withdrawalService->getWithdrawalWallet($request);
    }

    public function store(Request $request)
    {
        return $this->withdrawalService->createWithdrawal($request);
    }
}
