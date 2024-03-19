<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        // require login
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        return $this->notificationService->getNotifications($request);
    }
}
