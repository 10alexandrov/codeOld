<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdMachine;
use App\Models\Delegation;



class IdmachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'name' => ['required', 'min:3'],
            'id' => ['numeric', 'min:1', 'max:999999'],

        ], [
            'name.required' => 'El nombre del la All Money es obligatorio ejem: Localidad donde se encuentra',
            'name.min' => 'El nombre de la All Money debe tener al menos :min caracteres',
            'id.numeric' => 'El ID debe ser númerico sin espacios ejem: 24999',
            'id.min' => 'La ID de la All Money debe tener al menos :min números',
            'id.max' => 'La ID de la All Money debe tener como máximo :max números',

        ]);

        $delegation_id = $request->delegation_id;

        $machine = new IdMachine();
        $machine->id = $request->id;
        $machine->name = $request->name;
        $machine->save();


        return redirect()->route('machines.show', $delegation_id);*/
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idMachines = IdMachine::whereIn('id', function ($query) use ($id) {
            $query->select('idmachine')
                ->from('locals')
                ->whereIn('zone_id', function ($query) use ($id) {
                    $query->select('id')
                        ->from('zones')
                        ->whereIn('delegation_id', function ($query) use ($id) {
                            $query->select('id')
                                ->from('delegations')
                                ->where('id', $id);
                        });
                });
        })->get();
        //$delegation = $idMachines[0]->local->zone->delegation;
        $machine = $idMachines->first();
        $delegation = Delegation::find($id);
        //dd($machine->locals->first()->zone->delegation);
        return view('idMachines.show', compact('idMachines','machine','delegation'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'id' => ['numeric', 'min:1', 'max:999999'],

        ], [
            'name.required' => 'El nombre del la All Money es obligatorio ejem: Localidad donde se encuentra',
            'name.min' => 'El nombre de la All Money debe tener al menos :min caracteres',
            'id.numeric' => 'El ID debe ser númerico sin espacios ejem: 24999',
            'id.min' => 'La ID de la All Money debe tener al menos :min números',
            'id.max' => 'La ID de la All Money debe tener como máximo :max números',

        ]);

        $delegation_id = $request->idMachines;
        //dd($delegation_id);
        $machine = IdMachine::find($id);
        $machine->id = $request->id;
        $machine->name = $request->name;
        $machine->save();

        return redirect()->route('machines.show', $delegation_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /*$machine = IdMachine::find($id);
        $machine->delete();
        return redirect()->route('machines.show');*/
    }
}
