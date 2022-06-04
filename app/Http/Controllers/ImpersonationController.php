<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function leave()
    {
        if (!session()->has('impersonate')) {
            abort(403);
        }
        // login as the super user in session
        Auth::login(User::withoutGlobalScope(TenantScope::class)->findOrFail(session('impersonate')));
        session()->forget('impersonate');

        return redirect('/');
    }
}
