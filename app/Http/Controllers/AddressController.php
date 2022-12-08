<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function index()
    {
        if(request()->wantsJson()) {
            return response()->json(['addresses' => Auth::user()->addresses]);
        }

        return Inertia::render('Settings/Addresses/Index', [
            'addresses' => Auth::user()->addresses,
        ]);
    }

    public function edit(Address $address)
    {
        return Inertia::render('Settings/Addresses/Edit', [
            'initialAddress' => $address,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'label' => ['required', 'string'],
            'building' => ['required', 'string'],
            'street' => ['required', 'string'],
            'state' => ['required', 'string'],
            'township' => ['required', 'string'],
            'city' => ['required', 'string'],
            'default' => ['required', 'boolean'],
        ]);

        if ($request->boolean('default')) {
            Auth::user()->addresses()
                ->where('default', 1)
                ->update(['default' => 0]);
        }

        $address = Auth::user()->addresses()->create($attributes);

        return response()->json(['address' => $address]);
    }

    public function update(Request $request, Address $address)
    {
        $attributes = $request->validate([
            'label' => ['required', 'string'],
            'building' => ['required', 'string'],
            'street' => ['required', 'string'],
            'state' => ['required', 'string'],
            'township' => ['required', 'string'],
            'city' => ['required', 'string'],
            'default' => ['required', 'boolean'],
        ]);

        if ($request->boolean('default')) {
            Auth::user()->addresses()
                ->where('default', 1)
                ->where('id', '!=', $address->id)
                ->update(['default' => 0]);
        }

        $address->update($attributes);

        return response()->json(['address' => $address]);
    }
}
