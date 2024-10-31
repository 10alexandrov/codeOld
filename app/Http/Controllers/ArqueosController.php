<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\Auxiliar;
use App\Models\Local;
use App\Models\Logs;
use App\Models\Machine;
use App\Models\Ticket;
use App\Models\TypeMachines;

use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArqueosController extends Controller
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
        // Mostrar todos los datos para depuración
        //dd('store' , $request->all());

        // Obtener los datos del formulario
        $localId = $request->input('local_id');
        $userId = $request->input('user_id');

        // Decodificar los datos JSON
        $maquinas = json_decode($request->input('maquinas', '[]'), true);
        $coins1 = json_decode($request->input('coin1', '[]'), true);
        $coins10 = json_decode($request->input('coin10', '[]'), true);
        $coins20 = json_decode($request->input('coin20', '[]'), true);
        $coins50 = json_decode($request->input('coin50', '[]'), true);
        $carga1 = json_decode($request->input('carga1', '[]'), true);
        $carga10 = json_decode($request->input('carga10', '[]'), true);
        $carga20 = json_decode($request->input('carga20', '[]'), true);
        $carga50 = json_decode($request->input('carga50', '[]'), true);
        $totals = json_decode($request->input('total', '[]'), true);

        // buscar la maquina para luego pasarle el alias al LOG
        $machineId = (int) $maquinas[0];
        $machineAlias = $this->buscarAlias($machineId);
        $recargas = [];

        for ($i = 0; $i < count($maquinas); $i++) {
            try {
                // Calcular el total basado en los valores recibidos
                $calculatedTotal = ($coins1[$i] ?? 0) * 1
                    + ($coins10[$i] ?? 0) * 10
                    + ($coins20[$i] ?? 0) * 20
                    + ($coins50[$i] ?? 0) * 50
                    + ($carga1[$i] ?? 0) * 1
                    + ($carga10[$i] ?? 0) * 10
                    + ($carga20[$i] ?? 0) * 20
                    + ($carga50[$i] ?? 0) * 50;

                // Comparar el total calculado con el total recibido
                $receivedTotal = $totals[$i] ?? 0;

                if ($calculatedTotal != $receivedTotal) {
                    Log::warning("Total calculado ({$calculatedTotal}) no coincide con el total recibido ({$receivedTotal}) para la máquina {$maquinas[$i]}.");
                    //dd('NO   coincide', $calculatedTotal);

                    continue; // O manejar el error de acuerdo a tus necesidades
                }
                //dd('coincide', $calculatedTotal);
                // Crear el registro para guardar en la base de datos
                $recarga = [
                    'maquina' => $maquinas[$i],
                    'value1' => $coins1[$i] ?? 0,
                    'value10' => $coins10[$i] ?? 0,
                    'value20' => $coins20[$i] ?? 0,
                    'value50' => $coins50[$i] ?? 0,
                    'carga1' => $carga1[$i] ?? 0,
                    'carga10' => $carga10[$i] ?? 0,
                    'carga20' => $carga20[$i] ?? 0,
                    'carga50' => $carga50[$i] ?? 0,
                    'total' => $calculatedTotal,
                    'local_id' => $localId,
                    'user_id' => $userId
                ];

                // Guardar solo si el total es diferente de 0
                if ($calculatedTotal != 0) {
                    $aux = new Auxiliar;
                    $aux->machine_id = $recarga['maquina'];
                    $aux->value1 = $recarga['value1'];
                    $aux->value10 = $recarga['value10'];
                    $aux->value20 = $recarga['value20'];
                    $aux->value50 = $recarga['value50'];
                    $aux->carga1 = $recarga['carga1'];
                    $aux->carga10 = $recarga['carga10'];
                    $aux->carga20 = $recarga['carga20'];
                    $aux->carga50 = $recarga['carga50'];
                    $aux->total = $recarga['total'];
                    $aux->user_id = $userId;

                    $aux->save();
                    $recarga['maquina'] = $machineAlias;
                    //dd($recarga,'antes del metodo');
                    // Puedes usar esta línea si quieres registrar el log de creación
                    $this->createSaveAuxLog($recarga); // problema con el log
                    $recargas[] = $recarga;
                }
            } catch (\Exception $e) {
                Log::error("Error al guardar auxiliar para la máquina {$maquinas[$i]}: " . $e->getMessage());
                continue;
            }
        }

        return redirect()->route("arqueos.show", $localId);
    }

    public function show(String $id)
    {

        $machines = $this->getmachines($id);
        //dd($machines);
        //try{
        $local = Local::find($id);

        //$typeTickets = $this->getTypeTickets($id);
        $auxData = $this->getAuxData($id);
        //dd($auxData);

        if (session()->get('ticketsFilter')) {
            $ticketsFilter = session()->get('ticketsFilter');
        } else {
            $ticketsFilter = new Collection();
        }

        if (session()->get('ticketsType')) {
            $ticketsType = session()->get('ticketsType');
        } else {
            $ticketsType = [];
        }

        if (session()->get('totalSumAux')) {
            $totalSumAux = session()->get('totalSumAux');
        } else {
            $totalSumAux = 0;
        }

        if (session()->get('recargas')) {
            $recargas = session()->get('recargas');
        } else {
            $recargas = [];
        }

        if (session()->get('usersRoot')) {
            $usersRoot = session()->get('usersRoot');
        } else {
            $usersRoot = [];
        }

        //dd($auxData);

        return view('arqueos.show', compact('local'/*, 'typeTickets'*/, 'auxData', 'ticketsFilter', 'ticketsType', 'totalSumAux', 'recargas', 'usersRoot', 'machines'));

        /*}catch (Exception $e) {
            return redirect("/");
        }*/
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
        //dd('update' , $request->all());

        try {
            $total = ($request->coin1 ?? 0) * 1 + ($request->coin10 ?? 0) * 10 + ($request->coin20 ?? 0) * 20 + ($request->coin50 ?? 0) * 50 + ($request->carga1 ?? 0) * 1 + ($request->carga10 ?? 0) * 10 + ($request->carga20 ?? 0) * 20 + ($request->carga50 ?? 0) * 50;

            // Encuentra el modelo por su ID
            $newAuxData = Auxiliar::findOrFail($id);
            $lastUpdatedAt = $newAuxData->updated_at;
            $oldData = $newAuxData->replicate();
            //dd($oldData, $newAuxData, $lastUpdatedAt);
            // Actualiza los atributos del modelo con los nuevos datos
            $newAuxData->machine_id = $request->machine_id;
            $newAuxData->value1 = $request->coin1;
            $newAuxData->value10 = $request->coin10;
            $newAuxData->value20 = $request->coin20;
            $newAuxData->value50 = $request->coin50;
            $newAuxData->carga1 = $request->carga1;
            $newAuxData->carga10 = $request->carga10;
            $newAuxData->carga20 = $request->carga20;
            $newAuxData->carga50 = $request->carga50;
            $newAuxData->total = $total;

            // Guarda el modelo actualizado en la base de datos
            $newAuxData->save();
            //dd($id);
            $idMachine = $request->machine_id; // pasarloa al metodo para buscar el local_id para pasarle la conexion y grabar el log de update
            $this->createUpdateAuxDataLog($oldData, $newAuxData, $lastUpdatedAt , $idMachine);

            // Retorna una respuesta de éxito
            return redirect()->back()->with('success', 'Carga actualizada exitosamente.');
        } catch (\Exception $e) {
            dd($e);
            // Maneja cualquier error que pueda ocurrir durante la actualización
            return redirect()->back()->with('success', 'Carga no actualizada.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        try {
            $auxData = Auxiliar::findOrFail($id); // Suponiendo que AuxData es el modelo que representa tus datos
            //dd($auxData);
            // Realiza la eliminación
            $auxData->delete();

            return redirect()->back()->with('success', 'Recarga auxiliar eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Error al eliminar la recarga auxiliar.');
        }
    }

    /*Creación de el log a la hora de crear una recarga auxiliar*/
    public function createSaveAuxLog($data)
    {
        //dd($data['maquina'], 'dentro del metodo');
        try {
            $text = 'Entradas mediante prometeo:<br>';
            //dd($data, 'dentro del TRY' , $text);

            if ($data['value1'] != 0) {
                $text .=  $data['value1'] . ' monedas de 1€ = ' . ($data['value1'] * 1) . '€<br>';
            }
            if ($data['value10'] != 0) {
                $text .=  $data['value10'] . ' billetes de 10€ = ' . ($data['value10'] * 10) . '€<br>';
            }
            if ($data['value20'] != 0) {
                $text .=  $data['value20'] . ' billetes de 20€ = ' . ($data['value20'] * 20) . '€<br>';
            }
            if ($data['value50'] != 0) {
                $text .=  $data['value50'] . ' billetes de 50€ = ' . ($data['value50'] * 50) . '€<br>';
            }
            if ($data['carga1'] != 0) {
                $text .= 'Se ha añadido una carga de ' . $data['carga1'] . ' monedas de 1€ = ' . ($data['carga1'] * 1) . '€<br>';
            }
            if ($data['carga10'] != 0) {
                $text .= 'Se ha añadido una carga de ' . $data['carga10'] . ' billetes de 10€ = ' . ($data['carga10'] * 10) . '€<br>';
            }
            if ($data['carga20'] != 0) {
                $text .= 'Se ha añadido una carga de ' . $data['carga20'] . ' billetes de 20€ = ' . ($data['carga20'] * 20) . '€<br>';
            }
            if ($data['carga50'] != 0) {
                $text .= 'Se ha añadido una carga de ' . $data['carga50'] . ' billetes de 50€ = ' . ($data['carga50'] * 50) . '€<br>';
            }

            $text .= '<br>Total: ' . $data['total'] . '€';

            $currentTime = Carbon::now();
            $micro = sprintf("%06d", ($currentTime->micro / 1000));

            $user = User::find($data['user_id']);

            //dd( $text . $currentTime . $micro . $user->name);

            $newCreateLog = DB::connection(nuevaConexion($data['local_id']))->table('logs')->insert([
                'Type' => 'Recarga ' . $data['maquina'],
                'Text' => $text,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo ' . $user->name
            ]);

            Logs::insert([
                'local_id' => $data['local_id'],
                'Type' => 'Recarga ' . $data['maquina'],
                'Text' => $text,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo ' . $user->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            //dd($e);
            // return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al generar logs']);
        }
    }

    // obtener todas las machines de este local con su $IDLOCAL
    public function getmachines($id)
    {
        $machines = Machine::where('local_id', $id)
            ->with(['loads', 'auxiliars'])  // Carga las relaciones loads y auxiliars
            ->get()
            ->sortBy('name');

        return $machines;
    }


    //obtener todos los pagos de las machines con su
    public function getPaymentsmachines($id) {}


    /*Obtener los diferentes tipos de maquinas que tiene ese local*/
    public function getTypeTickets($id)
    {
        // aqui queremos que traiga
        $ticketsType = Local::find($id)->type_machines()
            ->select('name')
            ->distinct()
            ->where('name', 'like', 'CCM%')
            ->orderBy('name', 'asc')
            ->pluck('name')
            ->toArray();

        return $ticketsType;
    }

    /*Obtener todas las recargas machines de los últimos 10 dias de un local*/
    public function getAuxData($id)
    {
        // traemos las maquinas machines con sus releaciones de cargas y recargas machines
        $machines = Machine::where('local_id', $id)
            ->whereBetween('created_at', [now()->subDays(10), now()]) // Filtrar por los últimos 10 días
            ->with(['loads', 'auxiliars']) // Carga las relaciones loads y auxiliars
            ->orderBy('created_at', 'desc') // Ordenar por fecha de creación, descendente
            ->orderBy('id', 'asc') // Ordenar por nombre de máquina, ascendente
            ->get();

        // Obtén la colección de 'auxiliars' para todas las máquinas
        $auxData = $machines->flatMap(function ($machine) {
            return $machine->auxiliars;
        });

        return $auxData;
    }


    /*Crear log a la hora de modificar una recarga auxiliar*/
    public function createUpdateAuxDataLog($oldData, $newAuxData, $lastUpdatedAt, $idMachine)
    {
        // coger el machine_id para coger los datos del local y poder pasalo a la conexion DB y crear el log
        $machineParaLocal = Machine::find($idMachine);
        $local_id = $machineParaLocal->local_id;
        //dd($machineParaLocal);
        try {
            //dd($oldData . $newAuxData . $lastUpdatedAt);
            $text = 'Anterior:<br>Recarga ' . $oldData->machine->alias . '<br>';

            if ($oldData->value1 != 0) {
                $text .=  $oldData->value1 . ' monedas de 1€ = ' . ($oldData->value1 * 1) . '€<br>';
            }
            if ($oldData->value10 != 0) {
                $text .=  $oldData->value10 . ' billetes de 10€ = ' . ($oldData->value10 * 10) . '€<br>';
            }
            if ($oldData->value20 != 0) {
                $text .=  $oldData->value20 . ' billetes de 20€ = ' . ($oldData->value20 * 20) . '€<br>';
            }
            if ($oldData->value50 != 0) {
                $text .=  $oldData->value50 . ' billetes de 50€ = ' . ($oldData->value50 * 50) . '€<br>';
            }
            if ($oldData->carga1 != 0) {
                $text .= 'Se ha añadido una carga de ' . $oldData->carga1 . ' monedas de 1€ = ' . ($oldData->carga1) * 1 . '€<br>';
            }
            if ($oldData->carga10 != 0) {
                $text .= 'Se ha añadido una carga de ' . $oldData->carga10 . ' billetes de 10€ = ' . ($oldData->carga10) * 10 . '€<br>';
            }
            if ($oldData->carga20 != 0) {
                $text .= 'Se ha añadido una carga de ' . $oldData->carga20 . ' billetes de 20€ = ' . ($oldData->carga20) * 20 . '€<br>';
            }
            if ($oldData->carga50 != 0) {
                $text .= 'Se ha añadido una carga de ' . $oldData->carga50 . ' billeted de 50€ = ' . ($oldData->carga50) * 50 . '€<br>';
            }

            $text .= '<br>Total: ' . $oldData->total . '€ <br>' . ($lastUpdatedAt ? $lastUpdatedAt->format('d/m/Y H:i') : 'Fecha no disponible');
            $text .= '<br><br>Actual:<br>Recarga ' . $newAuxData->machine->alias . '<br>';

            if ($newAuxData->value1 != 0) {
                $text .=  $newAuxData->value1 . ' monedas de 1€ = ' . ($newAuxData->value1 * 1) . '€<br>';
            }
            if ($newAuxData->value10 != 0) {
                $text .=  $newAuxData->value10 . ' billetes de 10€ = ' . ($newAuxData->value10 * 10) . '€<br>';
            }
            if ($newAuxData->value20 != 0) {
                $text .=  $newAuxData->value20 . ' billetes de 20€ = ' . ($newAuxData->value20 * 20) . '€<br>';
            }
            if ($newAuxData->value50 != 0) {
                $text .=  $newAuxData->value50 . ' billetes de 50€ = ' . ($newAuxData->value50 * 50) . '€<br>';
            }
            if ($oldData->carga1 != 0) {
                $text .= 'Se ha añadido una carga de ' . $newAuxData->carga1 . ' monedas de 1€ = ' . ($newAuxData->carga1) * 1 . '€<br>';
            }
            if ($oldData->carga10 != 0) {
                $text .= 'Se ha añadido una carga de ' . $newAuxData->carga10 . ' billetes de 10€ = ' . ($newAuxData->carga10) * 10 . '€<br>';
            }
            if ($oldData->carga20 != 0) {
                $text .= 'Se ha añadido una recarga de ' . $newAuxData->carga20 . ' billetes de 20€ = ' . ($newAuxData->carga20) * 20 . '€<br>';
            }
            if ($oldData->carga50 != 0) {
                $text .= 'Se ha añadido una recarga de ' . $newAuxData->carga50 . ' billetes de 50€ = ' . ($newAuxData->carga50) * 50 . '€<br>';
            }

            $text .= '<br>Total: ' . $newAuxData->total . '€';

            $currentTime = Carbon::now();
            $micro = sprintf("%06d", ($currentTime->micro / 1000));

            $user = User::find($newAuxData->user_id);

            $newCreateLog = DB::connection(nuevaConexion($local_id))->table('logs')->insert([
                'Type' => 'Actualizado recarga ' . $newAuxData->machine->alias,
                'Text' => $text,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo ' . $user->name
            ]);
            //dd($newAuxData->machine->alias);
            Logs::insert([
                'local_id' => $local_id,
                'Type' => 'Actualizado recarga ' . $newAuxData->machine->alias,
                'Text' => $text,
                'Link' => '',
                'DateTime' => $currentTime,
                'DateTimeEx' => $micro,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo ' . $user->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            //dd($e);
            // return redirect()->route("tickets.show", $local)->withErrors(['error' => 'Ocurrió un error al generar logs']);
        }
    }

    /*Obtención de los tickets y recargas machines segun filtro (Arqueo máquiina) */
    public function getTicketsFilter(Request $request, $local)
    {
        if ($request->dateInicio != null && $request->fin != null && $request->maquinaSelect != null && $request->dateInicio <= $request->fin) {
            $localDate = Local::find($local);

            $usersRoot = DB::connection(nuevaConexion($local))
                ->table('users')
                ->where('IsRoot', 1)
                ->pluck('User')
                ->toArray();

            $ticketsFilter = Ticket::where("local_id", $local)
                ->where(function ($query) use ($request, $usersRoot) {
                    $query->where("Type", $request->maquinaSelect)
                        ->orWhere(function ($query) use ($request, $usersRoot) {
                            $query->where("Comment", $request->maquinaSelect)
                                ->whereNotIn('User', $usersRoot); // Excluir usuarios solo si busca por Comment
                        });
                })
                ->where("Command", "!=", "ABORT")
                ->whereBetween("DateTime", [$request->dateInicio, $request->fin])
                ->orderby("DateTime", "DESC")
                ->get();

            //dd($ticketsFilter);

            $totalSumAux = Auxiliar::where('local_id', $local)
                ->where('machine', $request->maquinaSelect)
                ->whereBetween('created_at', [$request->dateInicio, $request->fin])
                ->sum('total');

            $recargas = Auxiliar::where('local_id', $local)
                ->where('machine', $request->maquinaSelect)
                ->whereBetween('created_at', [$request->dateInicio, $request->fin])
                ->get();

            if ($recargas->isEmpty()) {
                $recargas = [];
            }

            if (!$ticketsFilter->isEmpty() || !empty($recargas)) {
                return redirect()->route("arqueos.show", $local)
                    ->with('ticketsFilter', $ticketsFilter)
                    ->with('totalSumAux', $totalSumAux)
                    ->with('recargas', $recargas)
                    ->with('usersRoot', $usersRoot);
            } else {
                return redirect()->route('arqueos.show', $local);
            }
        } else {
            return redirect()->route('arqueos.show', $local);
        }
    }

    /*Obtener tipos de ticket dinamicamente segun fechas (EN DESUSO) */
    public function getTypes(Request $request, $local)
    {
        if ($request->dateInicio != null && $request->fin != null && $request->dateInicio <= $request->fin) {
            $localDate = Local::find($local);

            $ticketsType = Ticket::select('Type')
                ->distinct()
                ->where("local_id", $local)
                ->where('name', 'like', 'CCM%')
                ->whereBetween("DateTime", [$request->dateInicio, $request->fin])
                ->orderBy('Type', 'asc')
                ->pluck('Type')
                ->toArray();

            return response()->json($ticketsType);
        } else {
            return redirect()->route("arqueos.show", $local);
        }
    }

    public function buscarAlias($id){

        // Buscar la máquina por ID
        $machine = Machine::find($id);

        // pasarle el alias
        $alias = $machine->alias;

        return $alias;
    }
}
