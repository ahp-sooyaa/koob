<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /*
    * check user role to decide where to redirect
    */
    public function __invoke()
    {
        if (auth()->user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }

        // !instead of dashboard, i will redirect to profile page
        return redirect(route('profile.index'));
    }
}
