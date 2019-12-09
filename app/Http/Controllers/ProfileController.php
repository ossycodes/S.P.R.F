<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        auth()->user()->update(request()->all());
        return response()->json([],  Response::HTTP_NO_CONTENT);
    }
}
