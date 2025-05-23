<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function user_update_email(Request $request)
    {
        $userId = $request->user_id;
    
        $request->validate([
            'user_email' => 'required|max:255|email',

        ], [
            'user_email.required' => 'The email field is required.',
            'user_email.max' => 'The email field must not be greater than 255 characters.',
            'user_email.email' =>  'The email must be a valid email address.',
        ]);
        
        $userData = [
            'user_email' => $request->user_email,
        ];

        $userLast = User::where('user_id', $userId)->first();
        User::where('user_id', $userId)->update($userData);

        if ($request->user_email == $userLast['user_email']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Email updated successfully.');
    }

    public function user_update_pass(Request $request)
    {
        $userId = $request->user_id;
    
        $request->validate([
            'user_pass' => 'required|min:8|max:20|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/|confirmed',
        ], [
            'user_pass.required' => 'The password is required.',
            'user_pass.min' => 'The password must be at least 8 characters.',
            'user_pass.max' => 'The password must not be greater than 20 characters.',
            'user_pass.regex' => 'The password must contain at least one letter, one number, and one symbol.',
            'user_pass.confirmed' => 'The password confirmation does not match.',
        ]);
        
        $userData = [
            'user_pass' => Hash::make($request->user_pass),
        ];

        $userLast = User::where('user_id', $userId)->first();
        User::where('user_id', $userId)->update($userData);
        

        if ($request->user_pass == $userLast['user_pass']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function user_update_photo(Request $request)
    {
        $userId = $request->user_id;
    
        $request->validate([
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'user_photo.required' => 'Harap unggah foto.',
            'user_photo.image' => 'File harus berupa gambar.',
            'user_photo.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif.',
            'user_photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);
    
        if ($request->hasFile('user_photo')) {
            $user_photo_file = $request->file('user_photo');
            $user_photo_filename = LogicController::generateUniqueId('user', 'user_photo', 55) . '.' . $user_photo_file->getClientOriginalExtension();

            $user_photo_path = 'assets/img/pp/';
            $destinationPath = public_path($user_photo_path);
    
            $user = User::where('user_id', $userId)->first();
            if ($user && $user->user_photo) {
                $oldFilePath = public_path($user->user_photo);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }
    
            $user_photo_file->move($destinationPath, $user_photo_filename);
    
            User::where('user_id', $userId)->update(['user_photo' => $user_photo_path . $user_photo_filename]);
    
            return redirect()->back()->with('success', 'Photo updated successfully.');
        }
    
        return redirect()->back()->with('error', 'No photo uploaded.');
    }

    public function user_update_name(Request $request)
    {
        $userId = $request->user_id;
    
        $request->validate([
            'user_username' => [
                'required', 'min:6', 'max:20',
                Rule::unique('user', 'user_username')->ignore($userId, 'user_id'),
            ],
            'user_fullname' => 'required|min:3|max:255',
        ], [
            'user_username.required' => 'The username is required.',
            'user_username.min' => 'The username must be at least 6 characters.',
            'user_username.max' => 'The username must not be greater than 20 characters.',
            'user_username.unique' => 'The username has already been taken.',
            'user_fullname.required' => 'The full name field is required.',
            'user_fullname.min' => 'The full name field must be at least 3 characters.',
            'user_fullname.max' => 'The full name field must not be greater than 255 characters.',
        ]);
        
        $userData = [
            'user_username' => $request->user_username,
            'user_fullname' => $request->user_fullname,
        ];

        $userLast = User::where('user_id', $userId)->first();
        User::where('user_id', $userId)->update($userData);
        
        if ($request->user_username == $userLast['user_username'] && $request->user_fullname == $userLast['user_fullname']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Name updated successfully.');
    }

    public function user_update_desc(Request $request)
    {
        $userId = $request->user_id;
    
        $request->validate([
            'user_desc' => 'max:350',

        ], [
            'user_desc.max' => 'The description field must not be greater than 350 characters.',
        ]);
        
        $userData = [
            'user_desc' => ($request->user_desc === '') ? null : $request->user_desc,
        ];

        $userLast = User::where('user_id', $userId)->first();
        User::where('user_id', $userId)->update($userData);

        if ($request->user_desc == $userLast['user_desc']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Description updated successfully.');
    }
}
