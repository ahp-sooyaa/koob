<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }

        return redirect(route('dashboard'));
    }
}
