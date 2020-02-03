<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return User::orderBy('created_at', 'desc')
            ->get()
            ->map
            ->format();
    }
}
