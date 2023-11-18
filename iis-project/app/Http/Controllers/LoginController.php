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

        if ($user && password_verify($password, $passwordHash)) {
            session(['user' => $user->email]);
            session(['is_admin' => $user->is_admin]);
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

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('homepage');
    }

    public function profile()
    {
        $user = UserModel::where('email', session('user'))->first();
        return view('profile', ['user' => $user]);
    }

    public function profilePost(Request $request)
    {
        $user = UserModel::where('email', session('user'))->first();
        $user->first_name = $request->input('first_name') ? $request->input('first_name') : $user->first_name;
        $user->last_name = $request->input('last_name') ? $request->input('last_name') : $user->last_name;
        $user->username = $request->input('username') ? $request->input('username') : $user->username;
        $user->is_public = $request->input('is_public') == "true" ? 1 : 0;
        $user->save();

        return redirect()->route('homepage');
    }

    public function users()
    {
        $isAdmin = (boolean)session('is_admin');
        $users = $isAdmin ? $this->listUsersAdmin() : $this->listUsers();
        return view('users', ['users' => $users, 'isAdmin' => $isAdmin]);
    }

    private function listUsers()
    {
        $users = UserModel::select('id', 'username', 'first_name', 'last_name')->where('is_public', 1)->get();
        return $users;
    }

    private function listUsersAdmin()
    {
        $users = UserModel::select('id', 'username', 'first_name', 'last_name', 'email', 'is_public')->get();
        return $users;
    }

    private function getUser($id)
    {
        $user = UserModel::select('id', 'username', 'first_name', 'last_name')->where('id', $id)->first();
        return $user;
    }

    private function getUserAdmin($id)
    {
        $user = UserModel::select('id', 'username', 'first_name', 'last_name', 'email', 'is_public')->where('id', $id)->first();
        return $user;
    }

    public function user($id)
    {
        $isAdmin = (boolean)session('is_admin');
        $user = $isAdmin ? $this->getUserAdmin($id) : $this->getUser($id);
        return view('user', ['user' => $user, 'isAdmin' => $isAdmin]);
    }
}
