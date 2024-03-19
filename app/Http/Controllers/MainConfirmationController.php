<?php

namespace App\Http\Controllers;

use App\Auth\AuthManager;
use App\Http\Controllers\Controller;

class MainConfirmationController extends Controller
{
    public function __construct()
    {
        // require login
        $this->middleware('auth');
    }
    public function index()
    {
        $permission = AuthManager::isAdmin();
        return view("main_confirmation.index",  compact('permission'));
    }
}
