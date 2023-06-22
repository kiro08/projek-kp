<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB; 
use App\Models\Food;

class usercontroller extends Controller
{
     public function open()
    {
        return view('open');
    }
}
