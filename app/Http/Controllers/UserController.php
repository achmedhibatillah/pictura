<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 
        view('templates/header') . 
        view('user/index') . 
        view('templates/footer');
    }
}
