<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login_page()
    {
        return 
        view('templates/header') . 
        view('auth/login-user') . 
        view('templates/footer');
    }

    public function register_page()
    {
        return 
        view('templates/header') . 
        view('auth/register-user') . 
        view('templates/footer');
    }

    public function login_auth(Request $request)
    {
        $request->validate([
            'user_identification' => 'required',
            'user_pass' => 'required',
        ], [
            'user_identification.required' => 'The username or email field is required.',
            'user_pass' => 'The password field is required.',
        ]);

        $user = User::where('user_username', $request->user_identification)->orWhere('user_email', $request->user_identification)->first();

        if ($user && Hash::check($request->user_pass, $user->user_pass)) {
            session([
                'is_user' => true,
                'user' => $user,
            ]);
            return redirect('/');
        }

        return redirect()->back()->with('error', 'Invalid authentication.')->withInput();
    }

    public function register_auth(Request $request)
    {
        $request->validate([
            'user_email' => 'required|max:255|email',
            'user_fullname' => 'required|min:3|max:255',
            'user_username' => 'required|min:6|max:20|unique:user,user_username',
            'user_pass' => 'required|min:8|max:20|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/',
        ], [
            'user_email.required' => 'The email field is required.',
            'user_email.max' => 'The email field must not be greater than 255 characters.',
            'user_email.email' =>  'The email must be a valid email address.',
            'user_fullname.required' => 'The full name field is required.',
            'user_fullname.min' => 'The full name field must be at least 3 characters.',
            'user_fullname.max' => 'The full name field must not be greater than 255 characters.',
            'user_username.required' => 'The username is required.',
            'user_username.min' => 'The username must be at least 6 characters.',
            'user_username.max' => 'The username must not be greater than 20 characters.',
            'user_username.unique' => 'The username has already been taken.',
            'user_pass.required' => 'The password is required.',
            'user_pass.min' => 'The password must be at least 8 characters.',
            'user_pass.max' => 'The password must not be greater than 20 characters.',
            'user_pass.confirmed' => 'The password confirmation does not match.',
            'user_pass.regex' => 'The password must contain at least one letter, one number, and one symbol.',
        ]);
        
        $userData = [
            'user_id' => LogicController::generateUniqueId('user', 'user_id', 35),
            'user_email' => $request->user_email,
            'user_fullname' => $request->user_fullname,
            'user_username' => $request->user_username,
            'user_pass' => Hash::make($request->user_pass),
            'user_who' => 3,
        ];

        User::create($userData);
        $userData = User::where('user_id', $userData['user_id'])->first();
        session([
            'is_user' => true,
            'user' => $userData,
        ]);
        return redirect('/');
    }
}
