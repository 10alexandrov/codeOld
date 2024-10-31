<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBossDelRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Delegation;

class BossDelegationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function edit(string $id){

        $user = User::find($id);
        $delegations = Delegation::where('id', '<>', 0)->get();

        $idDelegationsUser = $user->delegation()->get();

        return view('bossDelegations.edit', compact('user', 'delegations', 'idDelegationsUser'));
    }

    public function create(){

        $delegations = Delegation::where('id', '<>', 0)->get();
        //dd($delegations);
        return view('bossdelegations.create', compact('delegations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewBossDelRequest $request)
    {

        $bossTecnis = new User();
        $bossTecnis->name = $request->nameUser;
        $bossTecnis->email = $request->emailUser;
        $bossTecnis->password = $request->passUser;
        $bossTecnis->assignRole('Jefe Delegacion');
        $bossTecnis->save();

        foreach($request->Delegations as $delegation_id){
            $bossTecnis->delegation()->attach($delegation_id);
        }

        return redirect()->route('delegations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $user = User::find($id);
        //dd($request);

        $request->validate([
            'nameUser' => ['required', 'string', 'max:255'],
            'emailUser' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'passUser' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
            'passUserUpdate' => ['nullable', 'min:8', 'regex:/^([A-HJ-NP-SUVW]\d{7}[0-9A-J])|(\d{8}[A-Z])$/'],
            'Delegations' => ['required', 'array', 'min:1'],
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
            'passUserUpdate.regex' => 'La contraseña debe contener al menos una letra mayúscula y un número.',
            'Delegations.required' => 'La selección de un delegación es obligatoria',
            'Delegations.min' => 'Tiene que seleccionar 1 delegación como mínimo',
        ]);

        // falta por comporbar contraseña admin, para poder cambiar la contraseña de dicho usuario

        if (password_verify($request->passUser, auth()->user()->password)) {
            $user->name = $request->nameUser;
            $user->email = $request->emailUser;
            if ($request->passUserUpdate != null) {
                $user->password = $request->passUserUpdate;
            }
            $user->save();
            $user->delegation()->sync($request->Delegations);

            return redirect()->route('delegations.index');

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
        return redirect()->route('delegations.index');
    }
}
