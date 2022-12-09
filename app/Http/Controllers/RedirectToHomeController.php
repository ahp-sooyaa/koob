<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RedirectToHomeController extends Controller
{
    public function __invoke()
    {
        if (Auth::user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }

        // instead of user dashboard, i will redirect to profile page
        return redirect(route('profile.edit'));
    }
}
