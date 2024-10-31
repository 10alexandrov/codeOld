<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Local;
use App\Models\Delegation;


use Illuminate\Http\Request;

class ZonesController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameZone' => ['required', 'min:3', 'regex:/^[^\d]+$/'],
        ], [
            'nameZone.required' => 'El nombre de la delegación es obligatorio',
            'nameZone.min' => 'El nombre de la delegación debe tener al menos :min caracteres',
            'nameZone.regex' => 'El nombre de la delegación no puede contener números',
        ]);

        $zone = new Zone();
        $zone->name = $request->nameZone;
        $zone->delegation_id = $request->idDelegation;
        $zone->save();

        $mensaje = 'Zona creada!';
        //dd($zone->delegation_id);
        return redirect()->route('delegations.show', $request->idDelegation)->with('mensaje', $mensaje);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try{
            $zone = Zone::with(['locals', 'bars'])->find($id);
            //dd($zone);
            if (!is_null($zone)) {
                $delegation = $zone->delegation;
                return view('zones.show', compact('zone', 'delegation'));
            } else {
                return abort(404);
            }
        } catch (\Exception $e) {
            return redirect("/");
        }
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
        $zone = Zone::find($id);

        if (!is_null($zone)) {
            $zone->update($request->except('_token'));
            $delegation = Delegation::with('zones')->find($request->delegation_id);
            return redirect()->route('delegations.show', $delegation);
        } else {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $zone = Zone::find($id);

        if (!is_null($zone)) {
            $zone->delete();
            $delegation = Delegation::with('zones')->find($request->delegation_id);
            return redirect()->route('delegations.show', $delegation);
        } else {
            return abort(404);
        }
    }
}
