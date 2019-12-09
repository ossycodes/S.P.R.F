<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function update(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt(request('new_password'))
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
