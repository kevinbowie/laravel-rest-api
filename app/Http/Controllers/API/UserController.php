<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function users() {
        $users = User::all();
        return response()->json(Api::response($users));
    }

    public function register(Request $req) {
        $data = $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $data['password'] = bcrypt($data['password']);
        $data['api_token'] = bcrypt($data['email'] . $data['password']);

        $user = User::create($data);

        return response()->json(Api::response($user), 201);
    }

    public function login(Request $req)
    {
        if (!Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            return response()->json(['error' => 'Your credential is wrong'], 401);
        }

        $user = User::find(Auth::user()->id);
        return response()->json(Api::response($user, [
            'token' => $user->api_token
        ]));
    }

    public function profile() {
        $user = User::with('newestPosts')->find(Auth::user()->id);
        return response()->json(Api::response($user));
    }

    public function profileById($id)
    {
        $user = User::with('newestPosts')->find($id);
        return response()->json(Api::response($user));
    }
}
