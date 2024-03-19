<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TradeService;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    private $tradeService;

    public function __construct(TradeService $tradeService)
    {
        // require login
        $this->middleware('auth');
        $this->tradeService = $tradeService;
    }

    public function index(Request $request)
    {
        return $this->tradeService->getAllTrade($request);
    }

    public function page_trade()
    {
        return $this->tradeService->viewPage();
    }

    public function page_trade_transaction()
    {
        return $this->tradeService->viewPageTransaction();
    }

    public function page_trade_transaction_admin()
    {
        return $this->tradeService->viewPageTransactionAdmin();
    }

    public function store(Request $request)
    {
        return $this->tradeService->createTrade($request);
    }
}
