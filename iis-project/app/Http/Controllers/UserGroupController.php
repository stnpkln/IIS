<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function groups()
    {
        $isAdmin = session('is_admin');

        return view('groups');
    }

    private function listGroups
}
