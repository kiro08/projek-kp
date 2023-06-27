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
 
<<<<<<< HEAD
            return redirect()->route('Dashboard');
=======
            return redirect()->route('dashboard');
>>>>>>> bfed1cffbeac4692372e5b5de9c2eb8b1a337ea3
        }
 
        
        return response()->json(['message' => 'error']);
    }
}
