<?php

namespace App\Http\Controllers;

use App\Services\PrivacyService;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    private $privacyService;

    public function __construct(PrivacyService $privacyService)
    {
        $this->middleware('auth');
        $this->privacyService = $privacyService;
    }

    public function index(Request $request)
    {
        return $this->privacyService->getPrivacy($request);
    }

    public function store(Request $request)
    {
        return $this->privacyService->createPrivacy($request);
    }

    public function update(Request $request)
    {
        return $this->privacyService->updatePrivacy($request);
    }
}
