<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;
use App\Models\Zone;

class CollectsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idmachine)
    {

        $local = Local::where('idmachine', $idmachine)->first();

        if (!is_null($local)) {

            $localnew = new LocalsController();
            $collects =  $localnew->collect($idmachine);
            $collectsinfo = $collects[0];
            $valoresActivoyNoActivo = $collects[1];
            return view('collects.index', compact('local', 'collectsinfo', 'valoresActivoyNoActivo'));
        } else {
            return abort(404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
