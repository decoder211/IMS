<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admincontroller extends Controller
{
    //
    public function dashboard()
{
    if (Auth::check() && Auth::user()->type == 'user') {
        return view('dashboard');
    } elseif (Auth::check() && Auth::user()->type == 'admin') {
        return view('admin.dashboard');
    } else {
        return redirect('/');
    }
}

}
