<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginPost;

class LoginController extends Controller
{
    public function login(LoginPost $request){
        $usuario = User::where('name', $request->name)->first();
        if (!$usuario || !Hash::check($request->password, $usuario->password)){
            $error = 'Usuario incorrecto';
            return view('inicio', compact('error'));
        } else {
            return redirect()->route('delegations.index');
        }
    }
}
