<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }
}
