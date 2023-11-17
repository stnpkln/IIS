<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = UserModel::where('email', $email)->first();
        $passwordHash = $user->password;

        \Log::info(json_encode($user));
        if ($user && password_verify($password, $passwordHash)) {
            $request->session()->put('user', $user);
            return redirect()->route('homepage');
        } else {
            return redirect()->route('login');
        }
    }
    
    public function registerPost(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        
        $email = $request->input('email');
        $password = password_hash($request->input('password'), PASSWORD_BCRYPT);
        $name = $request->input('first_name');
        $surname = $request->input('last_name');
        $isPublic = $request->input('is_public');
        $username = $request->input('username');
        
        $user = new UserModel();
        $user->email = $email;
        $user->password = $password;
        $user->first_name = $name;
        $user->last_name = $surname;
        $user->is_public = $isPublic == "true" ? 1 : 0;
        $user->username = $username ? $username : "$name $surname";
        $user->save();

        return redirect()->route('login');
    }
}
