<?php

namespace App\Http\Controllers;

use App\Services\TransferCoinService;
use Illuminate\Http\Request;

class TransferCoinController extends Controller
{
    private $transferCoinService;

    public function __construct(TransferCoinService $transferCoinService)
    {
        $this->middleware('auth');
        $this->transferCoinService = $transferCoinService;
    }

    public function page()
    {
        return view('transfer_coin.index');
    }

    public function page_admin()
    {
        return $this->transferCoinService->page_admin();
    }

    public function index(Request $request)
    {
        return $this->transferCoinService->getTransferCoin($request);
    }

    public function store(Request $request)
    {
        return $this->transferCoinService->createTransferCoin($request);
    }
}
