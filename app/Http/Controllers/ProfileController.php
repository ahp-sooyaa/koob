<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $totalPurchasedBooks = 0;

        foreach (auth()->user()->orders as $order) {
            foreach ($order->books as $book) {
                $totalPurchasedBooks += $book->pivot->quantity;
            }
        }

        return Inertia::render('Profile', [
            'totalOrderCount' => count(auth()->user()->orders),
            'totalSpentAmount' => auth()->user()->orders->sum('total'),
            'totalPurchasedBooks' => $totalPurchasedBooks,
            'pendingOrders' => count(auth()->user()->orders()->where('status', 0)->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('Setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos');

            if(Auth::user()->profile_photo_path) {
                Storage::delete(Auth::user()->profile_photo_path);
            }

            Auth::user()->forceFill(['profile_photo_path' => $path])->update();
        }

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return Redirect::back()->with('success', 'Successfully updated your profile.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profilePasswordUpdate(Request $request)
    {
        Validator::make($request->input(), [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ])->after(function ($validator) use ($request) {
            if (! Hash::check($request->current_password, Auth::user()->password)) {
                $validator->errors()->add('current_password', 'Current Password doesn\'t match');
            }
        })->validate();

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return Redirect::back()->with('success', 'Successfully updated your password.');
    }
}
