<?php

namespace App\Http\Controllers;

use App\Models\Delegation;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Middleware\CheckDelegacionAccess;


class DelegationsController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $error = session()->get('error');

        switch (true) {
            case $user->hasRole('Super Admin'):
                $tecnicoRole = Role::where('name', 'Jefe Delegacion')->first();

                $delegations = Delegation::where('id', '<>', 0)->with('zones')->get();
                $usuariosJefes = $tecnicoRole->users;

                return view('delegations.index', compact('delegations', 'usuariosJefes', 'error'));
                break;

            case $user->hasRole('Jefe Delegacion'):
                $delegations = $user->delegation()->get();
                return view('delegations.index', compact('delegations', 'error'));
                break;

            case $user->hasRole('Jefe Salones'):
                $delegation = $user->delegation()->first();
                return redirect()->route('delegations.show', $delegation->id)->with('error', $error);
                break;

            case $user->hasRole('Oficina'):
                $delegation = $user->delegation()->first();
                return redirect()->route('delegations.show', $delegation->id)->with('error', $error);
                break;

            case $user->hasRole('Tecnico'):
                $delegation = $user->delegation()->first();
                return redirect()->route('delegations.show', $delegation->id)->with('error', $error);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('delegations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameDelegation' => ['required', 'min:3', 'regex:/^[^\d]+$/'],
        ], [
            'nameDelegation.required' => 'El nombre de la delegación es obligatorio',
            'nameDelegation.min' => 'El nombre de la delegación debe tener al menos :min caracteres',
            'nameDelegation.regex' => 'El nombre de la delegación no puede contener números',
        ]);

        //dd($request);

        $delegation = new Delegation();
        $delegation->name = $request->nameDelegation;
        $delegation->save();

        $mensaje = 'Delegación creada!';
        return redirect()->route('delegations.index', compact('mensaje'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $delegation = Delegation::with('zones.locals')->find($id);
        $error = session()->get('error');

        //dd($delegation->users);

        if (!is_null($delegation)) {
            return view('delegations.show', compact('delegation', 'error'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $delegation = Delegation::find($id);

        if (!is_null($delegation)) {
            return view('delegations.edit', compact('delegation'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delegation = Delegation::find($id);
        $delegation->update($request->except('_token'));

        if (!is_null($delegation)) {
            return redirect()->route('delegations.index');
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delegation = Delegation::find($id);

        if (!is_null($delegation)) {
            $delegation->delete();
            return redirect()->route('delegations.index');
        } else {
            abort(404);
        }
    }
}
