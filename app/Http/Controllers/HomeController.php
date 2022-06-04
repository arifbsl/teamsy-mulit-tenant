<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;

class HomeController extends Controller
{
    public function show()
    {
        if (!auth()->check()) {
            return view('welcome');
        } else {
            if (session()->has('tenant_id')) {
                return view('dashboard');
            }
            $subscribersCount = Tenant::count();
            $usersCount = User::count();
            $loginsCount = Login::count();
            return view('super.dashboard', [
                'subscribersCount' => $subscribersCount,
                'usersCount' => $usersCount,
                'loginsCount' => $loginsCount,
            ]);
        }
    }
}
