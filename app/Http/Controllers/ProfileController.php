<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $totalPurchasedBooks = 0;

        foreach ($user->orders as $order) {
            foreach ($order->books as $book) {
                $totalPurchasedBooks += $book->pivot->quantity;
            }
        }

        return Inertia::render('Profile', [
            'totalOrderCount' => count($user->orders),
            'totalSpentAmount' => $user->orders->sum('total'),
            'totalPurchasedBooks' => $totalPurchasedBooks,
            'pendingOrders' => count($user->orders()->where('status', 0)->get())
        ]);
    }

    public function edit()
    {
        return Inertia::render('Setting');
    }

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
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        return Redirect::back()->with('success', 'Successfully updated your profile.');
    }

    public function destroy($id)
    {
        //
    }
}
