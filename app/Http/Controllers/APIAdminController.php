<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class APIAdminController extends Controller
{
    public function sentUserRegisterEmail(Request $request)
    {
        $email = $request->email;
        $link = config('app.url');

        User::sendRegisterRequest($email, $link);
    }
}
