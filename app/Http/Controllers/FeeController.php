<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FeeService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    private $feeService;

    public function __construct(FeeService $feeService)
    {
        // require login
        $this->middleware('auth');
        $this->feeService = $feeService;
    }

    public function index()
    {
        return $this->feeService->viewPage();
    }

    public function show()
    {
        return $this->feeService->getFee();
    }

    public function store(Request $request)
    {
        return $this->feeService->createFee($request);
    }
}
