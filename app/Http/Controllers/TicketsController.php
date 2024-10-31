<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;
use App\Models\Local;
use App\Models\ConfigMC;
use App\Models\Ticket;
use App\Models\Auxmoneystorage;
use App\Models\TypeMachines;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use Exception;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        try{
            $local = Local::find($id);

           /*if (!is_null($local)) {
                $localnew = new LocalsController();
                $tickets =  $localnew->tickets($idmachine);
                return view('tickets.index', compact('local', 'tickets'));
            } else {
                return abort(404);
            }*/
            $abortTicket = $this->getAbortTickets($local->id);
            $confirmTicket = $this->getConfirmTickets($local->id);
            $allTypes = $this->getAllTypes();
            $auxiliaresName = $this->getAuxiliaresName($local->id);
            return view('tickets.show', compact('local','abortTicket','confirmTicket','allTypes','auxiliaresName'));
        }catch (\Exception $e) {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /*OBTENRT LOS TICKETS QUE SE PUEDEN ABORTAR*/
    public function getAbortTickets($id){
        $tickets = Ticket::where("local_id", $id)
        ->where(function($query) {
            $query->where('Command', 'OPEN')
                  ->orWhere('Command', 'PRINTED')
                  ->orWhere('Command', 'AUTHREQ');
        })
        ->get();

        return $tickets;
    }

    /*ABORTAR TICKETS*/
    public function abortTickets(Request $request,$local){
        try{
            if(!empty($request->tickets)){
                $user = "Prometeo_".auth()->user()->name;
                $date = Carbon::now('Europe/Madrid');
                $ip = getRealIpAddr();

                $localDate = Local::find($local);

                foreach($request->tickets as $ticket){
                    $updateTicket = DB::connection(nuevaConexion($local))->table('tickets')
                    ->where("TicketNumber", $ticket)
                    ->update([
                        'LastCommandChangeDateTime' => $date,
                        'Command'=>'ABORT',
                        'Used'=>'0',
                        'LastIP'=> $ip,
                        'LastUser'=>$user
                    ]);

                    $updateTicket = Ticket::where("TicketNumber", $ticket)
                    ->update([
                        'LastCommandChangeDateTime' => $date,
                        'Command'=>'ABORT',
                        'Used'=>'0',
                        'LastIP'=> $ip,
                        'LastUser'=>$user
                    ]);

                    $getUpdateTicket =Ticket::where("TicketNumber", $ticket)->first();

                    $this->currentBalanceUser($getUpdateTicket->User,$getUpdateTicket->Value,$local);
                    $this->generarLogConfirm($local,$request->tickets,'abort');
                }

                return redirect()->route("tickets.show",$local);
            }else{
                return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al abortar tickets']);
            }
        }catch(\Exception $e){
            return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al abortar tickets']);
        }
    }

    /*SINCRONIZAR CURRENT BALANCE DEL USUARIO*/
    function currentBalanceUser($usuario,$valor,$local){
        try{
            $actualCurrentBalance = DB::connection(nuevaConexion($local))->table('users')
            ->where("User", $usuario)->value('currentbalance');

            if($actualCurrentBalance){
                $newCurrentBalance = $actualCurrentBalance - $valor;

                if($newCurrentBalance >= 0){
                    $updateCurrentValance = DB::connection(nuevaConexion($local))->table('users')
                    ->where("User", $usuario)
                    ->update([
                        'currentbalance' => $newCurrentBalance,
                    ]);
                }else{
                    $updateCurrentValance = DB::connection(nuevaConexion($local))->table('users')
                    ->where("User", $usuario)
                    ->update([
                        'currentbalance' => 0,
                    ]);
                }
            }else{
                return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al actualizar currentBalance']);
            }
        }catch(\Exception $e){
            return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al actualizar currentBalance']);
        }
    }

    /*OBTENRT LOS TICKETS QUE SE PUEDEN CONFIRMAR*/
    public function getConfirmTickets($id){
        $tickets = Ticket::where("local_id", $id)
        ->where('Command', 'AUTHREQ')
        ->get();

        return $tickets;
    }

    /*ABORTAR TICKETS*/
    public function confirmTicket(Request $request,$local){
        try{
            if(!empty($request->tickets)){
                $user = "Prometeo_".auth()->user()->name;
                $date = Carbon::now('Europe/Madrid');
                $ip = getRealIpAddr();

                $localDate = Local::find($local);

                foreach($request->tickets as $ticket){
                    $updateTicket = DB::connection(nuevaConexion($local))->table('tickets')
                    ->where("TicketNumber", $ticket)
                    ->update([
                        'LastCommandChangeDateTime' => $date,
                        'Command'=>'OPEN',
                        'Used'=>'0',
                        'LastIP'=> $ip,
                        'LastUser'=>$user
                    ]);

                    $updateTicket = Ticket::where("TicketNumber", $ticket)
                    ->update([
                        'LastCommandChangeDateTime' => $date,
                        'Command'=>'OPEN',
                        'Used'=>'0',
                        'LastIP'=> $ip,
                        'LastUser'=>$user
                    ]);
                }

                $this->generarLogConfirm($local,$request->tickets,'confirm');
                return redirect()->route("tickets.show",$local);
            }else{
                return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al confirmar tickets']);
            }
        }catch(\Exception $e){
            return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al confirmar tickets']);
        }
    }

    public function generarLogConfirm($id,$tickets,$action){
        try{
            foreach($tickets as $ticket){
                $currentTime = Carbon::now();
                $micro = sprintf("%06d", ($currentTime->micro / 1000));

                if($action == 'confirm'){
                    $text = 'Ticket confirmado en modo web: '.$ticket;
                }else if($action == 'abort'){
                    $text = 'Ticket abortado en modo web: '.$ticket;
                }else{
                    throw new Exception("Acción no válida: $action");
                }

                $newConfirmLog = DB::connection(nuevaConexion($id))->table('logs')->insert([
                    'Type' => 'log',
                    'Text' => $text,
                    'Link' => '',
                    'DateTime' => $currentTime,
                    'DateTimeEx' => $micro,
                    'IP' => getRealIpAddr(),
                    'User' => 'Prometeo'
                ]);
            }

        }catch(\Exception $e){
            //return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al generar logs']);
        }
    }

    public function generarTicket(Request $request, $local) {
        try {
            $localDate = Local::find($local);
            $config = ConfigMC::where("local_id", $local)->first();

            $newTicket = new Ticket;
            $newTicket->local_id = $local;
            $newTicket->idMachine = $localDate->idMachines;
            if ($request->Value >= $config->MoneyLimitThatNeedsAuthorization) {
                $newTicket->Command = "AUTHREQ";
            } else {
                $newTicket->Command = "OPEN";
            }

            if (!$request->TicketNumber || strlen($request->TicketNumber) != $config->NumberOfDigits) {
                $newTicket->TicketNumber = GenerateNewNumberFormat($config->NumberOfDigits);
            } else {
                $newTicket->TicketNumber = $request->TicketNumber;
            }

            $newTicket->Mode = $request->Mode;

            $newTicket->DateTime = Carbon::now();
            $newTicket->LastCommandChangeDateTime = Carbon::now();
            $newTicket->LastIP = getRealIpAddr();
            $newTicket->LastUser = "Prometeo";

            if ($request->Value >= 1) {
                $newTicket->Value = $request->Value;
            } else {
                throw new Exception("El valor debe ser mayor o igual a 1");
            }

            $newTicket->Residual = 0;
            $newTicket->IP = getRealIpAddr();
            $newTicket->User = "Prometeo";
            $newTicket->Comment = "Creado mediante prometeo";

            if ($request->TicketTypeText == null && !$request->TicketTypeSelect) {
                throw new Exception("Debes seleccionar un tipo");
            } else if ($request->TicketTypeSelect == "null") {
                $newTicket->Type = $request->TicketTypeText;
            } else {
                $newTicket->Type = $request->TicketTypeSelect;
            }

            if ($request->TicketTypeIsBets) {
                if ($request->TicketTypeIsAux == 0) {
                    $newTicket->TypeIsBets = true;
                } else {
                    throw new Exception("No puede ser apuesta y auxiliar a la vez");
                }
            } else {
                $newTicket->TypeIsBets = false;
            }
            $newTicket->TypeIsAux = $request->TicketTypeIsAux;
            $newTicket->HideOnTC = 0;
            $newTicket->Used = 0;
            $newTicket->TITOExpirationType = 0;

            $newTicket->save();

            // Construir el array de datos para la inserción
            $insertData = [
                'Command' => $newTicket->Command,
                'TicketNumber' => $newTicket->TicketNumber,
                'Mode' => $newTicket->Mode,
                'DateTime' => $newTicket->DateTime,
                'LastCommandChangeDateTime' => $newTicket->LastCommandChangeDateTime,
                'LastIP' => $newTicket->LastIP,
                'LastUser' => $newTicket->LastUser,
                'Value' => $newTicket->Value,
                'Residual' => $newTicket->Residual,
                'IP' => $newTicket->IP,
                'User' => $newTicket->User,
                'Comment' => $newTicket->Comment,
                'Type' => $newTicket->Type,
                'TypeIsBets' => $newTicket->TypeIsBets,
                'TypeIsAux' => $newTicket->TypeIsAux,
                'HideOnTC' => $newTicket->HideOnTC,
                'Used' => $newTicket->Used,
                'TITOExpirationType' => $newTicket->TITOExpirationType,
            ];

            // Condicionalmente agregar ExpirationDate
            if (isset($request->expired)) {
                $insertData['UsedDateTime'] = null;
                $insertData['ExpirationDate'] = null;
            }

            // Inserción en la base de datos utilizando la conexión mariadb
            DB::connection(nuevaConexion($local))->table('tickets')->insert($insertData);

            $this->generarLogCreate($local, $newTicket);
            return redirect()->route("tickets.show", $local);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al generar el ticket: ' . $e->getMessage()]);
        }
    }

    public function generarLogCreate($id,$ticket){
        try{
            //dd($ticket);
            $text1 = "Ticket ".$ticket->Type;

            if($ticket->TypeIsBets){
                $text1 .= "[BETS]";
            }else if($ticket->TypeIsAux != 0){
                $text1 .= "[AUX-".$ticket->TypeIsAux."]";
            }

            $formattedValue = number_format($ticket->Value, 2);
            $text1 .= " creado en modo web ".$ticket->TicketNumber." ".$formattedValue."€ (".$ticket->DateTime.")";

            $currentTime = Carbon::now();
            $micro = sprintf("%06d", ($currentTime->micro / 1000));

            $newCreateLog = DB::connection(nuevaConexion($id))->table('logs')->insert([
                'Type' => 'log',
                'Text' => $text1,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo'
            ]);

            $text2 = $ticket->Type."|".$ticket->TicketNumber."|".$formattedValue."|0.00|Prometeo|".$ticket->DateTime."||0|0000-00-00 00:00:00";

            $newCreateLogMovementTicket = DB::connection(nuevaConexion($id))->table('logs')->insert([
                'Type' => 'movementTicket',
                'Text' => $text2,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo'
            ]);
        }catch(\Exception $e){
           // return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al generar logs']);
        }
    }

    public function getAllTypes(){
        $types = TypeMachines::select('name')
        ->distinct()
        ->orderBy('name', 'asc')
        ->get();

        return $types;
    }

    public function getAuxiliaresName($id){
        $auxuliares = Auxmoneystorage::where("local_id",$id)
        ->orderBy('TypeIsAux', 'asc')
        ->get();

       return $auxuliares;
    }
}
