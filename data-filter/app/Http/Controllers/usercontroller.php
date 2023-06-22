<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use App\Models\User;

class usercontroller extends Controller
{
     public function open()
    {
        return view('open');
    }
    public function ceklogin(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('index');
        }
 
        
        return response()->json(['message' => 'error']);
    }
}
