<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use App\Models\Promotion;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'cart' => ! empty($request->session()->get('cart'))
                ? array_values($request->session()->get('cart'))
                : [],
            'buyNow' => ! empty($request->session()->get('buyNow'))
                ? array_values($request->session()->get('buyNow'))
                : [],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'promotion' => Promotion::whereDate('starts_at', '<', now())->whereDate('ends_at', '>', now())->first(),
        ]);
    }
}
