<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Delegation;
use App\Models\SyncLogsLocals;

class AllMoneysController extends Controller
{
    // probando los cambios con el git

    public function verMoneys($idDelegation)
    {
        $delegation = Collect::allMoneys($idDelegation);
        $syncLogslocals = SyncLogsLocals::conectionMoneys($idDelegation);
        //dd($delegation);

        return view('allmoneys.verMoneys', compact('delegation', 'syncLogslocals'));

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(string $id)
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



















