<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Notifications\NewTransactionNotification;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['me', 'login', 'register', 'resetToDefault']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'          =>  'required',
            'email'         =>  'required|email',
            'contact_no'    =>  'required',
            'organization'  =>  'required',
            'password'      =>  'required'
        ]);

        $user = User::create([
            'name'                  =>  $request->input('name'),
            'email'                 =>  $request->input('email'),
            'contact_no'            =>  $request->input('contact_no'),
            'organization'          =>  $request->input('organization'),
            'password'              =>  bcrypt($request->input('password')),
            'password_is_default'   =>  0
        ]);


        return response()->json([
            'message'   =>  'User created!'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     =>  'required',
            'password'  =>  'required'
        ]);

        if (!$token = auth()->attempt(request(['email', 'password']))) {
            return response()->json([
                'message'   =>  'Sorry we can\'t find you with those details.'
            ], 422);
        }

        if (Transaction::where('status', 'CLOCKED IN')->where('user_id', $request->user()->id)->first()) {
            return response()->json([
                'message'   =>  'You Already Have An Existing Transaction'
            ], 401);
        } else {
            return (new UserResource($request->user()))->additional([
                'meta'  => [
                    'token' => $token
                ]
            ]);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message'   =>  'User logged out!'
        ]);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    public function resetPassword(Request $request) 
    {
        $request->validate([
            'current'   =>  'required',
            'new'       =>  'required'
        ]);

        User::where('id', $request->user()->id)->update([
            'password'              =>  bcrypt($request->input('new')),
            'password_is_default'   =>  0
        ]);

        return response()->json([
            'message'   =>  'Password Resetted!'
        ], 200);
    }

    public function resetToDefault($userId)
    {
        User::where('id', $userId)->update([
            'password'              =>  bcrypt('p@ssw0rd'),
            'password_is_default'   =>  1
        ]);

        return response()->json([
            'message'   =>  'The default password: p@ssw0rd'
        ], 200);
    }
}
