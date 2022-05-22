<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }

        // instead of user dashboard, i will redirect to profile page
        return redirect(route('profile.index'));
    }
}
