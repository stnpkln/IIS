<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function homepage() {
        if (session('user') === null) {
            return view('landing');
        } else {
            return redirect()->route('groups.me');
        }
    }
}
