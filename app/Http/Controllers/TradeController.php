<?php

namespace App\Http\Controllers;

use App\Auth\AuthManager;
use App\Models\Trade;
use App\Services\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // get trading card views
    public function get_trading_by_user(Request $request)
    {
        $page = $request->get('page', 1);
        $size = $request->get('size', 10);

        $trading = DB::table('tbltrde')->select(
            'tradeid',
            'feepercent',
            'feeamount',
            'amount',
            'totalamount',
            'namecurrency',
            'wintrade',
            'lastprice',
            //'logocurrency',
            'dateupdate',
            'timeupdate',
            'timetrade',
            'tradetitle',
            'status'
        )
            ->where('fkuserid', AuthManager::getAuthId())
            ->orderByDesc('tradeid')
            ->paginate($size, ['*'], 'page', $page);

        return view('trade.box-trade-view', compact('trading'));
    }
}
