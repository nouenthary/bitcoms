<?php

namespace App\Http\Controllers;


use App\Services\WalletTitleService;
use Illuminate\Http\Request;

class WalletTitleController extends Controller
{
    private $walletTitleService;

    public function __construct(WalletTitleService $walletTitleService)
    {
        // require login
        $this->middleware('auth');
        $this->walletTitleService = $walletTitleService;
    }

    public function wallet_title_page()
    {
        return $this->walletTitleService->viewPage();
    }

    public function index(Request $request)
    {
        return $this->walletTitleService->getWalletTitles($request);
    }

    public function store(Request $request)
    {
        return $this->walletTitleService->createWalletTitle($request);
    }

    public function update(Request $request)
    {
        return $this->walletTitleService->updateWalletTitle($request);
    }

    public function show($id)
    {
        return $this->walletTitleService->getWalletTitleId($id);
    }

    public function delete(Request $request)
    {
        return $this->walletTitleService->deleteWalletTitle($request);
    }
}
