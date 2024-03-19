<?php

namespace App\Http\Controllers;


use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        // require login
        $this->middleware('auth');
        $this->walletService = $walletService;
    }

    public function wallet_page()
    {
        return view('wallet.index');
    }

    public function index(Request $request)
    {
        return $this->walletService->getWallets($request);
    }

    public function store(Request $request)
    {
        return $this->walletService->createWallet($request);
    }

    public function update(Request $request)
    {
        return $this->walletService->updateWallet($request);
    }

    public function show(Request $request)
    {
        return $this->walletService->getWalletId($request);
    }

    public function delete(Request $request)
    {
        return $this->walletService->deleteWallet($request);
    }
}
