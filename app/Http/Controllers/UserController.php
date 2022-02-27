<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('hasPortal:settings');
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'photo' => 'nullable|string',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'username' => $fields['username'],
            'photo' => $fields['photo'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'hasPortal' => true,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'user' => 'required|string',
            'password' => 'required|string'
        ]);

        // check email or username
        $user = User::where('email', $fields['user'])
            ->orWhere('username', $fields['user'])
            ->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'bad credentials'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'hasPortal' => true,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response([
            'hasPortal' => true,
            'message' => 'Logged out'
        ]);
    }

    public function addPortal(Request $request){

    }

    public function deletePortal(Request $request){

    }

    public function destroy($id){
        //delete user
        //created_by/updated_by/deleted_by -> null
    }
}
