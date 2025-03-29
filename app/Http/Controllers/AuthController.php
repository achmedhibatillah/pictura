<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login_page()
    {
        return 
        view('templates/header') . 
        view('auth/login-user') . 
        view('templates/footer');
    }
}
