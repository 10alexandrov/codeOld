<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocalRequest;
use App\Models\AuxmoneystorageInfo;
use App\Models\CollectInfo;
use App\Models\Local;
use App\Models\Zone;
use Illuminate\Support\Facades\Artisan;

class LocalsController extends Controller
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
    public function create($id)
    {
        $zone = Zone::find($id);
        return view('locals.create', ['zone' => $zone]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocalRequest $request)
    {
        //dd($request->all());

        $local = new Local();
        $local->name = $request->nameLocal;
        $local->zone_id = $request->zone_id;
        $local->dbconection = json_encode($request->dbConexion); // Convertimos todas las conexiones en JSON
        $local->idMachines = $request->machine_id;
        $local->save();

        Artisan::call('prometeo:sync-money ' . $local->id);
        Artisan::call('prometeo:sync-money-synchronization24h ' . $local->id);
        Artisan::call('prometeo:sync-money-auxmoneystorage ' . $local->id);
        Artisan::call('prometeo:sync-money-config ' . $local->id);
        return redirect()->route('zones.show', $request->zone_id);
    }

    /**
     * Display the specified resource.
     */
    /*public function show(string $id)
    {
        //dd($id);
        try{
            // Encuentra el Local con sus relaciones
            $local = Local::with(['collects', 'collectDetails', 'tickets', 'latest_updates'])->find($id);

            //dd($local->latest_updates);
            $updates = $this->verificarCambios($local->id);

            // Obtener los datos como un array asociativo usando getData()
            $updatesArray = $updates->getData(true); // Pasa true para obtener los datos como array
            // Convertir los datos a un objeto stdClass para acceso directo
            $updatesObject = (object) $updatesArray;

            //$ultima_actulizacion_collect = $updatesObject->collectUpdate;
            //$ultima_actulizacion_collectDetails = $updatesObject->collectdetailsUndate;

            if (!is_null($local)) {

                // Pasar la colección de COLLECT al método estático
                // calculo del Dinero Activo
                $totalRecicladores = Collect::totalRecicladores($local->collects);
                $totalPagadores = Collect::totalPagadores($local->collects);
                $totalMultimoneda = Collect::totalMultimoneda($local->collects);
                $dineroActivo = Collect::dineroActivo($local->collects);

                // Pasar la colección de COLLECT al método estático
                // calculo del Dinero No Activo
                $totalApiladores = Collect::totalApiladores($local->collects);
                $totalRechazoDispensador = Collect::totalRechazoDispensador($local->collects);
                $totalCajones = Collect::totalCajones($local->collects);
                $totalCajonesVirtuales = Collect::totalCajonesVirtuales($local->collects);
                $dineroNoActivo = Collect::dineroNoActivo($local->collects);

                // arqueo total de COLLECT
                $arqueoTotal = Collect::arqueoTotal($local->collects);

                // Crear el array asociativo con los datos de COLLECT
                $dataCollects = [
                    'totalRecicladores' => (string)$totalRecicladores,
                    'totalPagadores' => (string)$totalPagadores,
                    'totalMultimoneda' => (string)$totalMultimoneda,
                    'dineroActivo' => (string)$dineroActivo,
                    'totalApiladores' => (string)$totalApiladores,
                    'totalRechazoDispensador' => (string)$totalRechazoDispensador,
                    'totalCajones' => (string)$totalCajones,
                    'totalCajonesVirtuales' => (string)$totalCajonesVirtuales,
                    'dineroNoActivo' => (string)$dineroNoActivo,
                    'arqueoTotal' => (string)$arqueoTotal,
                ];

                // Devolver los datos como JSON
                $aux = json_encode($dataCollects);
                $collectsData = json_decode($aux);

                //ordenadno los campos para la tabla COLLECT
                $orderedCollectionJson = Collect::colocarCampos($local->collects);
                $collectOrdenado =  json_decode($orderedCollectionJson);

                // Pasar la colección de COLLECTDETAILS al método estático
                $calculoCollectDetails50 = Collectdetail::valoresParaCollectDetails50($local->collectDetails);
                $principalDisponible = Collectdetail::disponible($local->collectDetails);
                $apuestas = Collectdetail::apuestas($local->collectDetails);
                $disponible = Collectdetail::disponible($local->collectDetails);
                $auxiliares = Collectdetail::auxiliares($local->collectDetails);

                // Crear el array asociativo con los datos de Collectdetail
                $dataCollectDetails = [
                    'calculoCollectDetails50' => $calculoCollectDetails50,
                    'apuestas' => $apuestas->values()->all(),
                    'disponible' => $disponible->values()->all(),
                    'auxiliares' => $auxiliares->values()->all(),
                ];

                // Devolver los datos como JSON
                $aux = json_encode($dataCollectDetails);
                $collectDetailsData = json_decode($aux);

                //calculo del total de los tickets segun el tipo
                $ticketsFilter = Ticket::where('local_id', $local->id)
                                ->where('Command', 'CLOSE')
                                ->where('TypeIsAux', 0)
                                ->where('TypeIsBets', '!=', 1)
                                ->where('Status', 'IN STACKER')
                                ->whereBetween('LastCommandChangeDateTime', [
                                    DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                                    DB::raw('NOW()'),
                                ])
                                ->get();

                $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);
                $ticketsData = json_decode($totalTicketsSegunTipo);

                //dd($disponible, $calculoCollectDetails50);

                return view('locals.show', compact('local', 'collectsData', 'collectDetailsData', 'ticketsData', 'collectOrdenado','updatesObject','ticketsFilter'));
            } else {

                return abort(404);
            }
        }catch(\Exception $e){
            dd($e);
            return redirect("/");
        }
    }*/

    public function show(string $id)
    {
        //dd($id);

        // Encuentra el Local con sus relaciones
        $local = Local::find($id);
        //dd($local);

        return view('locals.show', compact('local'));
    }

    /*public function show(string $id)
    {
        // Encuentra el Local con sus relaciones
        $local = Local::with(['collects', 'collectDetails', 'tickets'])->find($id);
        $syncLocal = SyncLogsLocals::find($id);

        // Verificar cambios y obtener la última modificación
        $verificarChanges = $this->verificarCambios($local->id);
        $ultimaModificacionAux = json_decode($verificarChanges->getContent(), true);

        // Inicializar la variable para la última modificación
        $ultimaModificacion = null;

        // Verificar y depurar el contenido de ultimaModificacionAux
        if (!empty($ultimaModificacionAux) && isset($ultimaModificacionAux[0]['ultima_modificacion'])) {
            // Extraer la fecha de última modificación
            $modificacion = $ultimaModificacionAux[0]['ultima_modificacion'];

            // Verificar si modificacion es una cadena
            if (is_string($modificacion)) {
                $ultimaModificacion = Carbon::parse($modificacion)->format('d-m-Y H:i');
            } else {
                // Si es un array, verificar los campos internos
                foreach (['collects', 'collectDetails', 'tickets'] as $campo) {
                    if (isset($modificacion[$campo])) {
                        $campoModificacion = $modificacion[$campo];
                        // Verificar si el valor es un array y extraer la cadena de texto adecuada
                        if (is_array($campoModificacion) && isset($campoModificacion[0]) && is_string($campoModificacion[0])) {
                            $ultimaModificacion = Carbon::parse($campoModificacion[0])->format('d-m-Y H:i');
                            break;
                        } elseif (is_string($campoModificacion)) {
                            $ultimaModificacion = Carbon::parse($campoModificacion)->format('d-m-Y H:i');
                            break;
                        }
                    }
                }
            }
        }

        if (is_null($ultimaModificacion)) {
            // Si no se pudo determinar una última modificación, manejar esto adecuadamente
            $ultimaModificacion = 'No hay datos de última modificación disponibles';
        }

        // Para depurar, puedes usar dd($ultimaModificacionAux) aquí para verificar los datos
        // dd($ultimaModificacionAux);

        $syncLocalCollect = $local->collects;
        $syncLocalCollectDetails = $local->collectDetails;
        $syncLocalTickets = $local->tickets;

        if (!is_null($local)) {
            // Pasar la colección de COLLECT al método estático
            // cálculo del Dinero Activo
            $totalRecicladores = Collect::totalRecicladores($local->collects);
            $totalPagadores = Collect::totalPagadores($local->collects);
            $totalMultimoneda = Collect::totalMultimoneda($local->collects);
            $dineroActivo = Collect::dineroActivo($local->collects);

            // Pasar la colección de COLLECT al método estático
            // cálculo del Dinero No Activo
            $totalApiladores = Collect::totalApiladores($local->collects);
            $totalRechazoDispensador = Collect::totalRechazoDispensador($local->collects);
            $totalCajones = Collect::totalCajones($local->collects);
            $totalCajonesVirtuales = Collect::totalCajonesVirtuales($local->collects);
            $dineroNoActivo = Collect::dineroNoActivo($local->collects);

            // arqueo total de COLLECT
            $arqueoTotal = Collect::arqueoTotal($local->collects);

            // Crear el array asociativo con los datos de COLLECT
            $dataCollects = [
                'totalRecicladores' => (string)$totalRecicladores,
                'totalPagadores' => (string)$totalPagadores,
                'totalMultimoneda' => (string)$totalMultimoneda,
                'dineroActivo' => (string)$dineroActivo,
                'totalApiladores' => (string)$totalApiladores,
                'totalRechazoDispensador' => (string)$totalRechazoDispensador,
                'totalCajones' => (string)$totalCajones,
                'totalCajonesVirtuales' => (string)$totalCajonesVirtuales,
                'dineroNoActivo' => (string)$dineroNoActivo,
                'arqueoTotal' => (string)$arqueoTotal,
            ];

            // Devolver los datos como JSON
            $aux = json_encode($dataCollects);
            $collectsData = json_decode($aux);

            //ordenando los campos para la tabla COLLECT
            $orderedCollectionJson = Collect::colocarCampos($local->collects);
            $collectOrdenado = json_decode($orderedCollectionJson);

            // Pasar la colección de COLLECTDETAILS al método estático
            $calculoCollectDetails50 = Collectdetail::valoresParaCollectDetails50($local->collectDetails);
            $principalDisponible = Collectdetail::disponible($local->collectDetails);
            $apuestas = Collectdetail::apuestas($local->collectDetails);
            $disponible = Collectdetail::disponible($local->collectDetails);
            $auxiliares = Collectdetail::auxiliares($local->collectDetails);

            // Crear el array asociativo con los datos de Collectdetail
            $dataCollectDetails = [
                'calculoCollectDetails50' => $calculoCollectDetails50,
                'apuestas' => $apuestas->values()->all(),
                'disponible' => $disponible->values()->all(),
                'auxiliares' => $auxiliares->values()->all(),
            ];

            // Devolver los datos como JSON
            $aux = json_encode($dataCollectDetails);
            $collectDetailsData = json_decode($aux);

            //cálculo del total de los tickets según el tipo
            $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($local->tickets);
            $ticketsData = json_decode($totalTicketsSegunTipo);

            return view('locals.show', compact('local', 'collectsData', 'collectDetailsData', 'ticketsData', 'collectOrdenado', 'syncLocal', 'ultimaModificacion'));
        } else {
            return abort(404);
        }
    }*/


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $local = Local::find($id);

        // Decodificar el JSON en un array de objetos
        //$local->dbconection = json_decode($local->dbconection, true);
        //dd($local);
        if ($local) {
            // Decodificar el JSON a un array de objetos
            $local->dbconection = json_decode($local->dbconection, true); // `true` para obtener un array asociativo
            //dd($local);
            return view('locals.edit', compact('local'));
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocalRequest $request, string $id)
    {

        //dd($request->all());

        $local = Local::find($id);

        if (!is_null($local)) {

            $local->name = $request->nameLocal;
            $local->zone_id = $request->zone_id;
            $local->dbconection = json_encode($request->dbConexion);
            $local->idMachines = $request->machine_id;

            $local->save();

            return redirect()->route('zones.show', $request->zone_id);
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $local = Local::find($id);

        if (!is_null($local)) {
            $zone_id = $local->zone_id;
            $local->delete();
            return redirect()->route('zones.show', $zone_id);
        } else {
            return abort(404);
        }
    }

    public function verificarCambios($id)
    {

        try {
            //dd($id);
            $ultimaModificacionCollectsInfo = CollectInfo::where('local_id', $id)->where('Machine', '!=', 'CCM')->first();
            $ultimaModificacionauxmoneystorageinfo = AuxmoneystorageInfo::where('local_id', $id)->where('Machine', '!=', 'CCM')->first();
            dd($ultimaModificacionCollectsInfo);

            $respuesta = [
                'collectUpdate' => $ultimaModificacionCollectsInfo->LastUpdateDateTime,
                'auxmoneystorageinfo' => $ultimaModificacionauxmoneystorageinfo->LastUpdateDateTime,
            ];

            return response()->json($respuesta);
        } catch (\Exception $e) {
            return redirect("/");
        }
    }

    /*  public function verificarCambios($id)
    {
        // Obtener el modelo Local con las relaciones cargadas
        $local = Local::with(['collects', 'collectDetails', 'tickets','latest_updates'])->find($id);

        // Obtener las fechas de última modificación de cada tabla relacionada para el local dado
        $ultimaModificacionCollects = $local->collects->max('updated_at');
        $ultimaModificacionCollectDetails = $local->collectDetails->max('updated_at');
        $ultimaModificacionTickets = $local->tickets->max('updated_at');

        // Obtener las fechas de última modificación guardadas en caché para cada tabla relacionada para el local dado
        $collectAnterior = Cache::get('collect_anterior_' . $id);
        $collectDetailsAnterior = Cache::get('collect_details_anterior_' . $id);
        $ticketsAnterior = Cache::get('tickets_anterior_' . $id);

        // Comparar las fechas de última modificación actuales con las anteriores para cada tabla
        $respuesta = [];

        // Comprobar si la tabla collects ha sido modificada
        if ($ultimaModificacionCollects && $ultimaModificacionCollects != $collectAnterior) {
            $respuesta[] = [
                'tabla' => 'collects',
                'ultima_modificacion' => $ultimaModificacionCollects->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'tabla' => 'collects',
                'ultima_modificacion' => $collectAnterior ? $collectAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla collectDetails ha sido modificada
        if ($ultimaModificacionCollectDetails && $ultimaModificacionCollectDetails != $collectDetailsAnterior) {
            $respuesta[] = [
                'tabla' => 'collectDetails',
                'ultima_modificacion' => $ultimaModificacionCollectDetails->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'tabla' => 'collectDetails',
                'ultima_modificacion' => $collectDetailsAnterior ? $collectDetailsAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla tickets ha sido modificada
        if ($ultimaModificacionTickets && $ultimaModificacionTickets != $ticketsAnterior) {
            $respuesta[] = [
                'tabla' => 'tickets',
                'ultima_modificacion' => $ultimaModificacionTickets->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'tabla' => 'tickets',
                'ultima_modificacion' => $ticketsAnterior ? $ticketsAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Actualizar las fechas de última modificación anteriores en caché
        Cache::put('collect_anterior_' . $id, $ultimaModificacionCollects);
        Cache::put('collect_details_anterior_' . $id, $ultimaModificacionCollectDetails);
        Cache::put('tickets_anterior_' . $id, $ultimaModificacionTickets);

        return response()->json($respuesta);
    }*/



    /* askodi*/
    /*public function verificarCambios($id)
    {
        // Obtener el modelo Local con las relaciones cargadas
        $local = Local::with(['collects', 'collectDetails', 'tickets'])->find($id);

        // Obtener los valores anteriores de las marcas de tiempo de cada tabla relacionada
        $collectAnterior = Cache::get('collect_anterior') ?? $local->collects->max('updated_at');
        $collectDetailsAnterior = Cache::get('collect_details_anterior') ?? $local->collectDetails->max('updated_at');
        $ticketsAnterior = Cache::get('tickets_anterior') ?? $local->tickets->max('updated_at');

        // Comparar las marcas de tiempo actuales con las anteriores
        $respuesta = [];

        $idMachine = $local->idMachines;
        $nombreLocal = $local->name; // Asumiendo que el nombre del local está en un campo llamado 'name'

        // Comprobar si la tabla collects ha sido modificada
        if ($local->collects->max('updated_at') != $collectAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collects',
                'mensaje' => 'La tabla collects ha sido modificada.',
                'ultima_modificacion' => $local->collects->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collects',
                'mensaje' => 'La tabla collects no ha sido modificada.',
                'ultima_modificacion' => $collectAnterior ? $collectAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla collectDetails ha sido modificada
        if ($local->collectDetails->max('updated_at') != $collectDetailsAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collectDetails',
                'mensaje' => 'La tabla collectDetails ha sido modificada.',
                'ultima_modificacion' => $local->collectDetails->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collectDetails',
                'mensaje' => 'La tabla collectDetails no ha sido modificada.',
                'ultima_modificacion' => $collectDetailsAnterior ? $collectDetailsAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla tickets ha sido modificada
        if ($local->tickets->max('updated_at') != $ticketsAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'tickets',
                'mensaje' => 'La tabla tickets ha sido modificada.',
                'ultima_modificacion' => $local->tickets->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'tickets',
                'mensaje' => 'La tabla tickets no ha sido modificada.',
                'ultima_modificacion' => $ticketsAnterior ? $ticketsAnterior->format('Y-m-d H:i:s') : null,
            ];
        }

        // Actualizar los valores anteriores de las marcas de tiempo en la caché
        Cache::put('collect_anterior', $local->collects->max('updated_at'));
        Cache::put('collect_details_anterior', $local->collectDetails->max('updated_at'));
        Cache::put('tickets_anterior', $local->tickets->max('updated_at'));

        return response()->json($respuesta);
    }*/

    /* chat GPT
    public function verificarCambios($id)
    {
        // Obtener el modelo Local con las relaciones cargadas
        $local = Local::with(['collects', 'collectDetails', 'tickets'])->find($id);

        // Generar claves de caché específicas para cada local
        $cacheKeyCollect = 'collect_anterior_' . $id;
        $cacheKeyCollectDetails = 'collect_details_anterior_' . $id;
        $cacheKeyTickets = 'tickets_anterior_' . $id;

        // Obtener los valores anteriores de las marcas de tiempo de cada tabla relacionada
        $collectAnterior = Cache::get($cacheKeyCollect) ?? $local->collects->max('updated_at');
        $collectDetailsAnterior = Cache::get($cacheKeyCollectDetails) ?? $local->collectDetails->max('updated_at');
        $ticketsAnterior = Cache::get($cacheKeyTickets) ?? $local->tickets->max('updated_at');

        // Comparar las marcas de tiempo actuales con las anteriores
        $respuesta = [];

        $idMachine = $local->idMachines;
        $nombreLocal = $local->name; // Asumiendo que el nombre del local está en un campo llamado 'name'

        // Comprobar si la tabla collects ha sido modificada
        if ($local->collects->max('updated_at') != $collectAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collects',
                'mensaje' => 'La tabla collects ha sido modificada.',
                'ultima_modificacion' => $local->collects->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collects',
                'mensaje' => 'La tabla collects no ha sido modificada.',
                'ultima_modificacion' => $collectAnterior ? Carbon::parse($collectAnterior)->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla collectDetails ha sido modificada
        if ($local->collectDetails->max('updated_at') != $collectDetailsAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collectDetails',
                'mensaje' => 'La tabla collectDetails ha sido modificada.',
                'ultima_modificacion' => $local->collectDetails->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'collectDetails',
                'mensaje' => 'La tabla collectDetails no ha sido modificada.',
                'ultima_modificacion' => $collectDetailsAnterior ? Carbon::parse($collectDetailsAnterior)->format('Y-m-d H:i:s') : null,
            ];
        }

        // Comprobar si la tabla tickets ha sido modificada
        if ($local->tickets->max('updated_at') != $ticketsAnterior) {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'tickets',
                'mensaje' => 'La tabla tickets ha sido modificada.',
                'ultima_modificacion' => $local->tickets->max('updated_at')->format('Y-m-d H:i:s'),
            ];
        } else {
            $respuesta[] = [
                'idMachine' => $idMachine,
                'nombreLocal' => $nombreLocal,
                'tabla' => 'tickets',
                'mensaje' => 'La tabla tickets no ha sido modificada.',
                'ultima_modificacion' => $ticketsAnterior ? Carbon::parse($ticketsAnterior)->format('Y-m-d H:i:s') : null,
            ];
        }

        // Actualizar los valores anteriores de las marcas de tiempo en la caché
        Cache::put($cacheKeyCollect, $local->collects->max('updated_at'));
        Cache::put($cacheKeyCollectDetails, $local->collectDetails->max('updated_at'));
        Cache::put($cacheKeyTickets, $local->tickets->max('updated_at'));

        return response()->json($respuesta);
    }*/




    /*verifica los cambios pero da la misma fecha para todos los locales y eso no es lo que queremos
        queremos que muestre la modificacion dependiendo del local que se actualicen segun el local
    */
    /* public function verificarCambios($id)
    {
        // Obtener el modelo Local con las relaciones cargadas
        $local = Local::with(['collects', 'collectDetails', 'tickets'])->find($id);

        // Obtener los valores anteriores de las marcas de tiempo de cada tabla relacionada
        $collectAnterior = Cache::get('collect_anterior') ?? $local->collects->max('updated_at');
        $collectDetailsAnterior = Cache::get('collect_details_anterior') ?? $local->collectDetails->max('updated_at');
        $ticketsAnterior = Cache::get('tickets_anterior') ?? $local->tickets->max('updated_at');

        // Comparar las marcas de tiempo actuales con las anteriores
        $respuesta = [];

        $idMachine = $local->idMachines;
        $nombreLocal = $local->name; // Asumiendo que el nombre del local está en un campo llamado 'name'

        // Iterar sobre las relaciones collects
        foreach ($local->collects as $collect) {
            if ($collect->updated_at != $collectAnterior) {
                $respuesta[] = [
                    'idMachine' => $idMachine,
                    'nombreLocal' => $nombreLocal,
                    'tabla' => 'collects',
                    'mensaje' => 'La tabla collects ha sido modificada.',
                    'ultima_modificacion' => $collect->updated_at ? $collect->updated_at->format('Y-m-d H:i:s') : null,
                ];
                break; // Detener la iteración una vez que se detecta un cambio
            }
        }

        // Iterar sobre las relaciones collectDetails
        foreach ($local->collectDetails as $collectDetail) {
            if ($collectDetail->updated_at != $collectDetailsAnterior) {
                $respuesta[] = [
                    'idMachine' => $idMachine,
                    'nombreLocal' => $nombreLocal,
                    'tabla' => 'collectDetails',
                    'mensaje' => 'La tabla collectDetails ha sido modificada.',
                    'ultima_modificacion' => $collectDetail->updated_at ? $collectDetail->updated_at->format('Y-m-d H:i:s') : null,
                ];
                break; // Detener la iteración una vez que se detecta un cambio
            }
        }

        // Iterar sobre las relaciones tickets
        foreach ($local->tickets as $ticket) {
            if ($ticket->updated_at != $ticketsAnterior) {
                $respuesta[] = [
                    'idMachine' => $idMachine,
                    'nombreLocal' => $nombreLocal,
                    'tabla' => 'tickets',
                    'mensaje' => 'La tabla tickets ha sido modificada.',
                    'ultima_modificacion' => $ticket->updated_at ? $ticket->updated_at->format('Y-m-d H:i:s') : null,
                ];
                break; // Detener la iteración una vez que se detecta un cambio
            }
        }

        // Actualizar los valores anteriores de las marcas de tiempo en la caché
        Cache::put('collect_anterior', $collectAnterior);
        Cache::put('collect_details_anterior', $collectDetailsAnterior);
        Cache::put('tickets_anterior', $ticketsAnterior);

        return json_encode($respuesta);
    }*/
}
