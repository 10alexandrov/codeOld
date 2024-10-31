<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Local;


class CollectdetailsController extends Controller
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
            $collectdetails =  $localnew->collectdetails($idmachine);
            $collectdetailsinfo = $collectdetails[0];
            $saldoInicial = $collectdetails[1];

            $porcientodel50 = $saldoInicial * 0.5;
            $principal = 0;

            foreach ($collectdetailsinfo as $principalfor) {
                if ($principalfor->Name == 'Principal') {
                    $principal = $principalfor->Money1;
                }
            }
            return view('collectdetails.index', compact('local', 'collectdetailsinfo', 'saldoInicial', 'porcientodel50', 'principal'));
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
