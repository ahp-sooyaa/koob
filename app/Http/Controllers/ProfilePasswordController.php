<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfilePasswordController extends Controller
{
    public function update(Request $request)
    {
        Validator::make($request->input(), [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ])->after(function ($validator) use ($request) {
            if (! Hash::check($request->input('current_password'), Auth::user()->password)) {
                $validator->errors()->add('current_password', "Current Password doesn't match");
            }
        })->validate();

        Auth::user()->update(['password' => Hash::make($request->input('password'))]);

        return Redirect::back()->with('success', 'Successfully updated your password.');
    }
}
