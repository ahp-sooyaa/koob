<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function index()
    {
        if(request()->wantsJson()) {
            return response()->json(['addresses' => Auth::user()->addresses]);
        }

        return Inertia::render('Settings/Addresses/Index', [
            'addresses' => Auth::user()->addresses()->latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Settings/Addresses/Create', [
            'isFirstAddress' => Auth::user()->addresses->isEmpty()
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

    public function destroy(Address $address)
    {
        if (Auth::user()->addresses->count() > 1 && $address->default) {
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'You can\'t delete your default address while you have more than one address'
                ], 422); 
            }
    
            return Redirect::back()->with('error', 'You can\'t delete your default address while you have more than one address');
        }
        
        $address->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => "Successfully deleted address"
            ]); 
        }

        return Redirect::back()->with('success', 'Successfully deleted address');
    }
}
