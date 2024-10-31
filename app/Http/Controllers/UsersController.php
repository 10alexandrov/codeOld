<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\User;
use App\Models\Delegation;
use Illuminate\Http\Request;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\NewBossDelRequest;

use App\Http\Requests\UpdateUserRequest;


class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $users = User::where('delegation_id', $id)->get();
        /*dd($users->toArray());*/
        $delegation = Delegation::find($id);
        return view('users.index', compact('users', 'delegation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //dd($id);
        $delegation = Delegation::find($id);
        return view('users.create', ['delegation' => $delegation]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NewUserRequest $request)
    {

        $user = new User();
        $user->name = $request->nameUser;
        $user->email = $request->emailUser;
        $user->password = $request->passUser;
        $user->save();
        $user->delegation()->attach($request->idDelegation);
        $user->assignRole('Tecnico');


        return redirect()->route('delegations.show', $request->idDelegation);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nameUser' => ['required', 'string', 'max:255'],
            'emailUser' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'passUser' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            'passUserUpdate' => ['nullable', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/']
        ], [
            'nameUser.required' => 'El nombre del usuario es obligatorio',
            'emailUser.required' => 'El correo electrónico es obligatorio',
            'emailUser.email' => 'El correo electrónico debe ser válido',
            'emailUser.unique' => 'El correo electrónico ya está en uso',
            'passUser.required' => 'La contraseña es obligatoria',
            'passUser.min' => 'La contraseña debe tener al menos :min caracteres',
            'passUser.regex' => 'La contraseña debe contener al menos una letra mayúscula y un número.',
            'passUserUpdate.required' => 'La contraseña es obligatoria',
            'passUserUpdate.min' => 'La contraseña debe tener al menos :min caracteres',
            'passUserUpdate.regex' => 'La contraseña debe contener al menos una letra mayúscula y un número.'
        ]);

        // falta por comporbar contraseña admin, para poder cambiar la contraseña de dicho usuario

        if (password_verify($request->passUser, auth()->user()->password)) {
            $user->name = $request->nameUser;
            $user->email = $request->emailUser;
            if ($request->passUserUpdate != null) {
                $user->password = $request->passUserUpdate;
            }
            $user->save();
            $user->delegation()->attach($request->idDelegation);

            return redirect()->route('delegations.show',$user->delegation()->first()->id);

        }else{
            return redirect()->back()->withErrors(['passUser' => 'La contraseña proporcionada no coincide con la contraseña actual del usuario.']);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $delegation_id = $user->delegation()->first();
        $user->delete();
        return redirect()->route('delegations.show', $delegation_id->id);
    }
}
