<?php

namespace App\Http\Controllers;

use App\Models\Delegation;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Models\UserTicketServer; // Cambia YourModel por el nombre de tu modelo
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function exportUsers($delegation_id)
    {
        try {
            $delegation = Delegation::findOrFail($delegation_id);
            // Realiza la consulta a la base de datos
            $usuarios = $delegation->usersTicketServer()->get(); // Ajusta la consulta según tus necesidades
            //dd($usuarios);

            // Genera el PDF usando la vista 'pdf.table'
            $pdf = PDF::loadView('pdf.userTicketServerTable', compact('usuarios', 'delegation'));

            // Retorna el PDF para que el usuario lo descargue
            return $pdf->download('Users_TicketServer.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function exportMachinesLocals($delegation_id)
    {
        try {
            $machines = Machine::where('delegation_id', $delegation_id)->where('local_id','!=',null)->get();

            //dd($machines);
            $delegation = Delegation::findOrFail($delegation_id);
            $locals = collect();
            foreach ($delegation->zones as $zone) {
                $locals = $locals->merge($zone->locals);
            }

            // Genera el PDF usando la vista 'pdf.table'
            $pdf = PDF::loadView('pdf.machinesLocalTable', compact('machines', 'delegation', 'locals'));
            // Retorna el PDF para que el usuario lo descargue
            return $pdf->download('maquinas_salones.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function exportMachinesBars($delegation_id)
    {
        try {
            $machines = Machine::where('delegation_id', $delegation_id)->where('bar_id','!=',null)->get();

            //dd($machines);
            $delegation = Delegation::findOrFail($delegation_id);
            $bars = collect();
            foreach ($delegation->zones as $zone) {
                $bars = $bars->merge($zone->bars);
            }

            // Genera el PDF usando la vista 'pdf.table'
            $pdf = PDF::loadView('pdf.machinesBarTable', compact('machines', 'delegation', 'bars'));
            // Retorna el PDF para que el usuario lo descargue
            return $pdf->download('maquinas_bares.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
