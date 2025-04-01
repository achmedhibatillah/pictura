<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToUserConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserCogController extends Controller
{
    public function edit_name(Request $request)
    {
        $userId = session('user')['user_id'];
    
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
        session([ 'user' => User::where('user_id', $userId)->first() ]);

        if ($request->user_username == $userLast['user_username'] && $request->user_fullname == $userLast['user_fullname']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Name updated successfully.');
    }

    public function edit_email(Request $request)
    {
        $userId = session('user')['user_id'];
    
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
        session([ 'user' => User::where('user_id', $userId)->first() ]);

        if ($request->user_email == $userLast['user_email']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Email updated successfully.');
    }

    public function edit_photo(Request $request)
    {
        $userId = session('user')['user_id'];
    
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
    
            session(['user' => User::where('user_id', $userId)->first()]);
            return redirect()->back()->with('success', 'Photo updated successfully.');
        }
    
        return redirect()->back()->with('error', 'No photo uploaded.');
    }

    public function edit_pass(Request $request)
    {
        $userId = session('user')['user_id'];

        $request->validate([
            'user_pass_old' => 'required',
        ], [
            'user_pass_old.required' => 'The password is required.',
        ]);
        
        $user = User::where('user_id', session('user')['user_id'])->first();
        
        if (!$user || !Hash::check($request->user_pass_old, $user->user_pass)) {
            return redirect()->back()->withErrors(['user_pass_old' => 'Wrong password.'])->withInput();
        }
    
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
        session([ 'user' => User::where('user_id', $userId)->first() ]);

        if ($request->user_pass == $userLast['user_pass']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function edit_desc(Request $request)
    {
        $userId = session('user')['user_id'];
    
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
        session([ 'user' => User::where('user_id', $userId)->first() ]);

        if ($request->user_desc == $userLast['user_desc']) {
            return redirect()->back();
        }

        return redirect()->back()->with('success', 'Description updated successfully.');
    }

    public function connect_connecting(Request $request)
    {
        $relationData = [
            'relation_id' => LogicController::generateUniqueId('user_to_user_connect', 'relation_id'),
            'user_id_src' => session('user')['user_id'],
            'user_id_dst' => $request->user_id_dst,
            'connect_status' => 0,
        ];

        UserToUserConnect::create($relationData);

        return redirect()->back();
    }

    public function connect_disconnect(Request $request)
    {
        UserToUserConnect::where('user_id_src', session('user')['user_id'])->where('user_id_dst', $request->user_id_dst)->delete();

        return redirect()->back();
    } 
}
