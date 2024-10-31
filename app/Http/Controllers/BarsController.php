<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use App\Models\Machine;
use App\Models\Zone;
use Illuminate\Http\Request;

class BarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index');
    }

    public function showBars($delegationID)
    {
        //dd($delegationID);
        $zones = Zone::with('bars')->find($delegationID);
        //dd($zones);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $zone = Zone::find($id);
        return view('bars.create', compact('zone'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => ['required', 'string'],
            'holder' => ['required', 'string'],
            'cif' => ['required', 'min:8', 'regex:/^([A-HJ-NP-SUVW]\d{7}[0-9A-J])|(\d{8}[A-Z])$/'], // Expresión regular para CIF o DNI
            'direccion' => ['required', 'string'],
            'poblacion' => ['required', 'string'],
            'zone' => ['required', 'exists:zones,id'], // Validar que la zona exista en la tabla zones
        ], [
            'name.required' => 'El nombre es obligatorio',
            'holder.required' => 'El titular es obligatorio',
            'cif.required' => 'El CIF o DNI es obligatorio',
            'cif.min' => 'El CIF o DNI debe tener al menos :min caracteres',
            'cif.regex' => 'El CIF o DNI debe tener un formato válido.', // Mensaje corregido
            'direccion.required' => 'La dirección es obligatoria',
            'poblacion.required' => 'La población es obligatoria',
            'zone.required' => 'La zona es obligatoria',
            'zone.exists' => 'La zona seleccionada no es válida', // Mensaje de error si la zona no existe
        ]);

        $bar = new Bar();
        $bar->name = $request->name;
        $bar->holder = $request->holder;
        $bar->dni_cif = $request->cif;
        $bar->address = $request->direccion;
        $bar->town = $request->poblacion;
        $bar->zone_id = $request->zone;

        $bar->save();

        return redirect()->route('zones.show', $bar->zone_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener el Local con sus máquinas y cargas
        $local = Bar::with(['machines.loads'])->find($id);

        // Verificar si la máquina fue encontrada
        if (!$local) {
            abort(404, 'Machine not found');
        }
        //dd($local);
        // Pasar los datos a la vista
        return view('bars.show', ['local' => $local]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bar = Bar::findOrFail($id);
        return view('bars.edit', compact('bar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'holder' => ['required', 'string'],
            'cif' => ['required', 'min:8', 'regex:/^([A-HJ-NP-SUVW]\d{7}[0-9A-J])|(\d{8}[A-Z])$/'], // Expresión regular para CIF o DNI
            'direccion' => ['required', 'string'],
            'poblacion' => ['required', 'string'],
            'zone' => ['required', 'exists:zones,id'], // Validar que la zona exista en la tabla zones
        ], [
            'name.required' => 'El nombre es obligatorio',
            'holder.required' => 'El titular es obligatorio',
            'cif.required' => 'El CIF o DNI es obligatorio',
            'cif.min' => 'El CIF o DNI debe tener al menos :min caracteres',
            'cif.regex' => 'El CIF o DNI debe tener un formato válido.', // Mensaje corregido
            'direccion.required' => 'La dirección es obligatoria',
            'poblacion.required' => 'La población es obligatoria',
            'zone.required' => 'La zona es obligatoria',
            'zone.exists' => 'La zona seleccionada no es válida', // Mensaje de error si la zona no existe
        ]);

        $bar = Bar::findOrFail($id);
        $bar->name = $request->name;
        $bar->holder = $request->holder;
        $bar->dni_cif = $request->cif;
        $bar->address = $request->direccion;
        $bar->town = $request->poblacion;
        $bar->zone_id = $request->zone;

        $bar->save();

        return redirect()->route('zones.show', $bar->zone_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        $bar = Bar::findOrFail($id);
        $bar->delete();
        return redirect()->route('zones.show', $bar->zone_id);
    }
}
