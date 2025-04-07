<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SuperUserController extends Controller
{
    public function index()
    {
        $myUser = User::where('user_id', session('user')['user_id'])->first();
        $usersData = User::where('user_id', '!=', session('user')['user_id'])->get();

        return 
        view('templates/header') . 
        view('superuser/index', [
            'user' => $myUser,
            'users' => $usersData,
        ]) . 
        view('templates/footer');
    }

    public function user_edit($user_id)
    {
        $userData = User::where('user_id', $user_id)->first();

        return 
        view('templates/header') . 
        view('superuser/user-edit', [
            'user' => $userData,
        ]) . 
        view('templates/footer');
    }

    public function user_add(Request $request)
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

        return redirect()->back()->with('success', 'User data with username @' . $userData['user_username'] . ' was successfully deleted.');
    }

    public function user_del(Request $request)
    {
        $userData = User::where('user_id', $request->user_id)->first();
        $postsData = Post::where('user_id', $userData->user_id)->get();

        foreach ($postsData as $x) {
            $slidesData = Slide::where('post_id', $x->post_id)->get();
    
            foreach ($slidesData as $y) {
                File::delete($y->slide_image);
            }

            Slide::where('post_id', $x->post_id)->delete();
        }

        Post::where('user_id', $userData->user_id)->delete();
        User::where('user_id', $request->user_id)->delete();

        return redirect()->back()->with('success', 'User data with username @' . $userData->user_username . ' was successfully deleted.');
    }
}
