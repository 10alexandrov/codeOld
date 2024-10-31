<?php

namespace App\Http\Controllers;

use App\Models\Auxmoneystorage;
use App\Models\AuxmoneystorageInfo;
use App\Models\Collect;
use App\Models\CollectDetail;
use App\Models\CollectInfo;
use App\Models\Local;
use App\Models\Logs;
use App\Models\Ticket;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class InfoController extends Controller
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
    /*public function show(Request $request, string $id)
    {
        // Encuentra el Local con sus relaciones
        $local = Local::with(['collects', 'collectDetails', 'tickets', 'auxmoneystorageinfo'])->find($id);

        if (is_null($local)) {
            return abort(404);
        }

        // Obtener datos de actualización
        $updates = $this->verificarCambios($local->id);
        $updatesArray = $updates->getData(true);
        $updatesObject = (object) $updatesArray;

        // Obtener máquinas únicas y contar
        $machines = $local->auxmoneystorageinfo->pluck('Machine')->unique();
        $countSelect = $machines->count() > 1;

        // Determinar si se ha seleccionado una máquina específica
        $selectedUserMoney = $request->input('userMoney');

        // Filtrar datos según la máquina seleccionada
        if ($countSelect) {
            // Si hay más de una máquina, filtrar según selectedUserMoney
            $selectedCollects = $selectedUserMoney ? $local->collects->where('Machine', $selectedUserMoney) : $local->collects;
            $selectedCollectDetails = $selectedUserMoney ? $local->collectDetails->where('Machine', $selectedUserMoney) : $local->collectDetails;
            $selectedTicketsFilter = Ticket::where('local_id', $local->id)
                ->where('Machine', $selectedUserMoney)
                ->where('Command', 'CLOSE')
                ->where('TypeIsAux', 0)
                ->where('TypeIsBets', '!=', 1)
                ->where('Status', 'IN STACKER')
                ->whereBetween('LastCommandChangeDateTime', [
                    DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                    DB::raw('NOW()'),
                ])
                ->get();
            $selectedTicketsRaros = Ticket::where('local_id', $local->id)
                ->where('Machine', $selectedUserMoney)
                ->where('Command', 'CLOSE')
                ->where('Status', 'MANUALLY VALIDATED')
                ->whereBetween('LastCommandChangeDateTime', [
                    DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                    DB::raw('NOW()'),
                ])
                ->get();
        } else {
            // Si solo hay una máquina, usar los datos completos
            $selectedCollects = $local->collects;
            $selectedCollectDetails = $local->collectDetails;
            $selectedTicketsFilter = Ticket::where('local_id', $local->id)
                ->where('Command', 'CLOSE')
                ->where('TypeIsAux', 0)
                ->where('TypeIsBets', '!=', 1)
                ->where('Status', 'IN STACKER')
                ->whereBetween('LastCommandChangeDateTime', [
                    DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                    DB::raw('NOW()'),
                ])
                ->get();
            $selectedTicketsRaros = Ticket::where('local_id', $local->id)
                ->where('Command', 'CLOSE')
                ->where('Status', 'MANUALLY VALIDATED')
                ->whereBetween('LastCommandChangeDateTime', [
                    DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                    DB::raw('NOW()'),
                ])
                ->get();
        }

        // Calcular datos basados en los datos filtrados o completos
        $totalRecicladores = Collect::totalRecicladores($selectedCollects);
        $totalPagadores = Collect::totalPagadores($selectedCollects);
        $totalMultimoneda = Collect::totalMultimoneda($selectedCollects);
        $dineroActivo = Collect::dineroActivo($selectedCollects);
        $totalApiladores = Collect::totalApiladores($selectedCollects);
        $totalRechazoDispensador = Collect::totalRechazoDispensador($selectedCollects);
        $totalCajones = Collect::totalCajones($selectedCollects);
        $totalCajonesVirtuales = Collect::totalCajonesVirtuales($selectedCollects);
        $dineroNoActivo = Collect::dineroNoActivo($selectedCollects);
        $arqueoTotal = Collect::arqueoTotal($selectedCollects);

        $dataCollects = [
            'totalRecicladores' => (string) $totalRecicladores,
            'totalPagadores' => (string) $totalPagadores,
            'totalMultimoneda' => (string) $totalMultimoneda,
            'dineroActivo' => (string) $dineroActivo,
            'totalApiladores' => (string) $totalApiladores,
            'totalRechazoDispensador' => (string) $totalRechazoDispensador,
            'totalCajones' => (string) $totalCajones,
            'totalCajonesVirtuales' => (string) $totalCajonesVirtuales,
            'dineroNoActivo' => (string) $dineroNoActivo,
            'arqueoTotal' => (string) $arqueoTotal,
        ];

        $orderedCollectionJson = Collect::colocarCampos($selectedCollects);
        $collectOrdenado = json_decode($orderedCollectionJson);

        $calculoCollectDetails50 = Collectdetail::valoresParaCollectDetails50($selectedCollectDetails);
        $principalDisponible = Collectdetail::disponible($selectedCollectDetails);
        $apuestas = Collectdetail::apuestas($selectedCollectDetails);
        $disponible = Collectdetail::disponible($selectedCollectDetails);
        $auxiliares = Collectdetail::auxiliares($selectedCollectDetails);

        $dataCollectDetails = [
            'calculoCollectDetails50' => $calculoCollectDetails50,
            'apuestas' => $apuestas->values()->all(),
            'disponible' => $disponible->values()->all(),
            'auxiliares' => $auxiliares->values()->all(),
        ];

        $ticketsData = Ticket::totalTickectsSegunTipo($selectedTicketsFilter);
        $ticketRarosData = json_decode($selectedTicketsRaros);
        $ticketsDataAnterior = Ticket::totalTickectsSegunTipo(Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('CURRENT_DATE - INTERVAL \'15 days\''),
                DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
            ])
            ->get());
        $ticketsDataActual = Ticket::totalTickectsSegunTipo(Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                Carbon::now()->copy()->startOfDay(),
                Carbon::now(),
            ])
            ->get());

        $ticketsData = json_decode($ticketsData);
        $ticketsDataAnterior = json_decode($ticketsDataAnterior);
        $ticketsDataActual = json_decode($ticketsDataActual);

        $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
        $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

        $logs = $this->logs($id, $local->idMachines);

        return view('info.show', compact(
            'local',
            'dataCollects',
            'dataCollectDetails',
            'ticketsData',
            'collectOrdenado',
            'updatesObject',
            'selectedUserMoney',
            'countSelect',
            'ticketRarosData',
            'ticketsDataAnterior',
            'ticketsDataActual',
            'todayName',
            'yesterdayName',
            'logs'
        ));
    }*/

    public function show(Request $request, string $id)
    {
        // Encuentra el Local con sus relaciones
        $local = Local::with(['collects', 'collectDetails', 'tickets', 'auxmoneystorageinfo'])->find($id);

        // Verificar si el Local existe
        if (is_null($local)) {
            return abort(404);
        }

        // Obtener máquinas únicas
        $machines = $local->auxmoneystorageinfo->pluck('Machine')->unique();

        // Filtrar las máquinas válidas que tienen datos
        $validMachines = $machines->filter(function ($machine) use ($local) {
            return $local->collects->where('UserMoney', $machine)->isNotEmpty() &&
                $local->collectDetails->where('UserMoney', $machine)->isNotEmpty() &&
                $local->auxmoneystorageinfo->where('Machine', $machine)->isNotEmpty();
        });

        // Si no hay máquinas válidas, redirigir a 404
        if ($validMachines->isEmpty()) {
            return abort(404);
        }

        // Obtener el valor de 'userMoney' desde el request, si no se ha seleccionado, usar el primer 'Machine' válido
        $selectedUserMoney = $request->input('userMoney');
        if (is_null($selectedUserMoney) || !$validMachines->contains($selectedUserMoney)) {
            $selectedUserMoney = $validMachines->first();
        }

        // Definir si hay más de una máquina para el select
        $countSelect = $validMachines->count() > 1;

        // Filtrar las relaciones por 'Machine'
        $local = Local::with([
            'collects' => function ($query) use ($selectedUserMoney) {
                $query->where('UserMoney', $selectedUserMoney);
            },
            'collectDetails' => function ($query) use ($selectedUserMoney) {
                $query->where('UserMoney', $selectedUserMoney);
            },
            'auxmoneystorageinfo' => function ($query) use ($selectedUserMoney) {
                $query->where('Machine', $selectedUserMoney);
            },
            'tickets' // No se filtra por 'Machine' en 'tickets'
        ])->find($id);

        // Verificar si alguna de las colecciones está vacía
        $hasData = $local->collects->isNotEmpty() &&
            $local->collectDetails->isNotEmpty() &&
            $local->auxmoneystorageinfo->isNotEmpty();

        // Si no hay datos en ninguna relación, redirigir a la página de detalle del local
        if (!$hasData) {
            return redirect()->route('info.show', ['id' => $local->id, 'userMoney' => $selectedUserMoney]);
        }

        // Verificar cambios (si esta función es necesaria)
        $updates = $this->verificarCambios($local->id);

        // Obtener los datos como un array asociativo usando getData()
        $updatesArray = $updates->getData(true); // Pasa true para obtener los datos como array
        $updatesObject = (object) $updatesArray;

        // Verificar que las relaciones existan antes de intentar acceder a sus propiedades
        $totalRecicladores = $local->collects ? Collect::totalRecicladores($local->collects) : 0;
        $totalPagadores = $local->collects ? Collect::totalPagadores($local->collects) : 0;
        $totalMultimoneda = $local->collects ? Collect::totalMultimoneda($local->collects) : 0;
        $dineroActivo = $local->collects ? Collect::dineroActivo($local->collects) : 0;

        $totalApiladores = $local->collects ? Collect::totalApiladores($local->collects) : 0;
        $totalRechazoDispensador = $local->collects ? Collect::totalRechazoDispensador($local->collects) : 0;
        $totalCajones = $local->collects ? Collect::totalCajones($local->collects) : 0;
        $totalCajonesVirtuales = $local->collects ? Collect::totalCajonesVirtuales($local->collects) : 0;
        $dineroNoActivo = $local->collects ? Collect::dineroNoActivo($local->collects) : 0;

        $arqueoTotal = $local->collects ? Collect::arqueoTotal($local->collects) : 0;

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

        $collectsData = json_decode(json_encode($dataCollects));

        // Ordenando los campos para la tabla COLLECT
        $orderedCollectionJson = Collect::colocarCampos($local->collects);
        $collectOrdenado = json_decode($orderedCollectionJson);

        // Verificar que las relaciones existan antes de intentar acceder a sus propiedades
        $calculoCollectDetails50 = $local->collectDetails ? Collectdetail::valoresParaCollectDetails50($local->collectDetails) : [];
        $principalDisponible = $local->collectDetails ? Collectdetail::disponible($local->collectDetails) : collect([]);
        $apuestas = $local->collectDetails ? Collectdetail::apuestas($local->collectDetails) : collect([]);
        $disponible = $local->collectDetails ? Collectdetail::disponible($local->collectDetails) : collect([]);
        $auxiliares = $local->collectDetails ? Collectdetail::auxiliares($local->collectDetails) : collect([]);

        // Crear el array asociativo con los datos de Collectdetail
        $dataCollectDetails = [
            'calculoCollectDetails50' => $calculoCollectDetails50,
            'apuestas' => $apuestas->values()->all(),
            'disponible' => $disponible->values()->all(),
            'auxiliares' => $auxiliares->values()->all(),
        ];

        $collectDetailsData = json_decode(json_encode($dataCollectDetails));

        // Calculo del total de los tickets según el tipo
        $ticketsFilter = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('NOW() - INTERVAL \'10 DAYS\''),
                DB::raw('NOW()'),
            ])
            ->get();

        $ticketsRaros = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('Status', 'MANUALLY VALIDATED')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('NOW() - INTERVAL \'10 DAYS\''),
                DB::raw('NOW()'),
            ])
            ->get();

        $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);

        // Tickets días anteriores a hoy
        $ticketsFilterAnterior = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('CURRENT_DATE - INTERVAL \'10 days\''),
                DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
            ])
            ->get();

        $totalTicketsSegunTipoDiaAnterior = Ticket::totalTickectsSegunTipo($ticketsFilterAnterior);

        // Obtenemos el tiempo actual y el inicio del día actual
        $now = Carbon::now();
        $startOfDay = $now->copy()->startOfDay();

        // Obtenemos los tickets de los últimos 15 días, pero solo los del día de hoy desde las 00:00
        $ticketsFilterActual = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                $startOfDay,
                $now,
            ])
            ->get();

        $totalTicketsSegunTipoDiaActual = Ticket::totalTickectsSegunTipo($ticketsFilterActual);

        $ticketsData = json_decode($totalTicketsSegunTipo);
        $ticketRarosData = json_decode($ticketsRaros);
        $ticketsDataAnterior = json_decode($totalTicketsSegunTipoDiaAnterior);
        $ticketsDataActual = json_decode($totalTicketsSegunTipoDiaActual);

        // Obtener el nombre del día de la semana
        $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
        $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

        $logs = $this->logs($id, $local->idMachines);

        // Retorna la vista con todos los datos necesarios
        return view('info.show', compact('local', 'collectsData', 'collectDetailsData', 'ticketsData', 'collectOrdenado', 'updatesObject', 'ticketsFilter', 'logs', 'ticketRarosData', 'ticketsDataAnterior', 'ticketsDataActual', 'todayName', 'yesterdayName', 'countSelect', 'validMachines', 'selectedUserMoney','machines'));
    }





    /**show de joan antes de cambios */
    /*public function show(Request $request, string $id)
    {
        // Encuentra el Local con sus relaciones
        $local = Local::with(['collects', 'collectDetails', 'tickets', 'auxmoneystorageinfo'])->find($id);
        // Obtener el valor de 'Machine' desde el request
        $selectedUserMoney = $request->input('userMoney');

        //dd($local);

        // Obtener máquinas únicas y contar
        $machines = $local->auxmoneystorageinfo->pluck('Machine')->unique();
        $countSelect = $machines->count() > 1;
        //dd($machines);
        if ($countSelect) {

            // Encuentra el Local y filtra las relaciones por 'Machine' excepto 'tickets'
            $local = Local::with([
                'collects' => function ($query) use ($selectedUserMoney) {
                    if ($selectedUserMoney) {
                        $query->where('UserMoney', $selectedUserMoney);
                    }
                },
                'collectDetails' => function ($query) use ($selectedUserMoney) {
                    if ($selectedUserMoney) {
                        $query->where('UserMoney', $selectedUserMoney);
                    }
                },
                'auxmoneystorageinfo' => function ($query) use ($selectedUserMoney) {
                    if ($selectedUserMoney) {
                        $query->where('Machine', $selectedUserMoney);
                    }
                },
                'tickets' // No se filtra por 'Machine' en 'tickets'
            ])->find($id);


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

                $ticketsRaros = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('Status', 'MANUALLY VALIDATED')
                    ->whereBetween('LastCommandChangeDateTime', [
                        DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                        DB::raw('NOW()'),
                    ])
                    ->get();

                $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);

                // tickets dias anterioriores ha hoy
                $ticketsFilterAnterior = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('TypeIsAux', 0)
                    ->where('TypeIsBets', '!=', 1)
                    ->where('Status', 'IN STACKER')
                    ->whereBetween('LastCommandChangeDateTime', [
                        DB::raw('CURRENT_DATE - INTERVAL \'15 days\''),
                        DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
                    ])
                    ->get();

                $totalTicketsSegunTipoDiaAnterior = Ticket::totalTickectsSegunTipo($ticketsFilterAnterior);

                // Obtenemos el tiempo actual y el inicio del día actual
                $now = Carbon::now();
                $startOfDay = $now->copy()->startOfDay();

                // Obtenemos los tickets de los últimos 15 días, pero solo los del día de hoy desde las 00:00
                $ticketsFilterActual = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('TypeIsAux', 0)
                    ->where('TypeIsBets', '!=', 1)
                    ->where('Status', 'IN STACKER')
                    ->whereBetween('LastCommandChangeDateTime', [
                        $startOfDay,
                        $now,
                    ])
                    ->get();

                $totalTicketsSegunTipoDiaActual = Ticket::totalTickectsSegunTipo($ticketsFilterActual);

                $ticketsData = json_decode($totalTicketsSegunTipo);
                $ticketRarosData = json_decode($ticketsRaros);
                $ticketsDataAnterior = json_decode($totalTicketsSegunTipoDiaAnterior);
                $ticketsDataActual = json_decode($totalTicketsSegunTipoDiaActual);

                // Obtener el nombre del día de la semana
                $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
                $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

                $logs = $this->logs($id, $local->idMachines);

                return view('info.show', compact('local', 'collectsData', 'collectDetailsData', 'ticketsData', 'collectOrdenado', 'updatesObject', 'ticketsFilter', 'logs', 'ticketRarosData', 'ticketsDataAnterior', 'ticketsDataActual', 'todayName', 'yesterdayName', 'countSelect','machines'));
            } else {

                return abort(404);
            }

        } else {

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

                $ticketsRaros = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('Status', 'MANUALLY VALIDATED')
                    ->whereBetween('LastCommandChangeDateTime', [
                        DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                        DB::raw('NOW()'),
                    ])
                    ->get();

                $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);

                // tickets dias anterioriores ha hoy
                $ticketsFilterAnterior = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('TypeIsAux', 0)
                    ->where('TypeIsBets', '!=', 1)
                    ->where('Status', 'IN STACKER')
                    ->whereBetween('LastCommandChangeDateTime', [
                        DB::raw('CURRENT_DATE - INTERVAL \'15 days\''),
                        DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
                    ])
                    ->get();

                $totalTicketsSegunTipoDiaAnterior = Ticket::totalTickectsSegunTipo($ticketsFilterAnterior);

                // Obtenemos el tiempo actual y el inicio del día actual
                $now = Carbon::now();
                $startOfDay = $now->copy()->startOfDay();

                // Obtenemos los tickets de los últimos 15 días, pero solo los del día de hoy desde las 00:00
                $ticketsFilterActual = Ticket::where('local_id', $local->id)
                    ->where('Command', 'CLOSE')
                    ->where('TypeIsAux', 0)
                    ->where('TypeIsBets', '!=', 1)
                    ->where('Status', 'IN STACKER')
                    ->whereBetween('LastCommandChangeDateTime', [
                        $startOfDay,
                        $now,
                    ])
                    ->get();

                $totalTicketsSegunTipoDiaActual = Ticket::totalTickectsSegunTipo($ticketsFilterActual);

                $ticketsData = json_decode($totalTicketsSegunTipo);
                $ticketRarosData = json_decode($ticketsRaros);
                $ticketsDataAnterior = json_decode($totalTicketsSegunTipoDiaAnterior);
                $ticketsDataActual = json_decode($totalTicketsSegunTipoDiaActual);

                // Obtener el nombre del día de la semana
                $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
                $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

                $logs = $this->logs($id, $local->idMachines);

                return view('info.show', compact('local', 'collectsData', 'collectDetailsData', 'ticketsData', 'collectOrdenado', 'updatesObject', 'ticketsFilter', 'logs', 'ticketRarosData', 'ticketsDataAnterior', 'ticketsDataActual', 'todayName', 'yesterdayName', 'countSelect'));
            } else {

                return abort(404);
            }
        }
    }*/
    /*public function show(string $id)
    {
        // Encuentra el Local con sus relaciones
        $local = Local::with(['collects', 'collectDetails', 'tickets', 'auxmoneystorageinfo'])->find($id);

        if (is_null($local)) {
            return abort(404);
        }

        $selectedUserMoney = request('userMoney');
        $countSelect = $local->auxmoneystorageinfo->count() > 1;

        // Obtener datos de actualización
        $updates = $this->verificarCambios($local->id);
        $updatesArray = $updates->getData(true);
        $updatesObject = (object) $updatesArray;

        // Filtrar datos basados en el número de elementos en auxmoneystorageinfo
        if ($countSelect) {
            // Si hay más de un elemento, filtrar según selectedUserMoney
            $selectedCollects = $selectedUserMoney ? $local->collects->where('UserMoney', $selectedUserMoney) : $local->collects;
            $selectedCollectDetails = $selectedUserMoney ? $local->collectDetails->where('UserMoney', $selectedUserMoney) : $local->collectDetails;
            $selectedAuxMoneyStorage = $selectedUserMoney ? $local->auxmoneystorageinfo->where('Machine', $selectedUserMoney) : $local->auxmoneystorageinfo;
        } else {
            // Si hay solo un elemento, usar los datos completos
            $selectedCollects = $local->collects;
            $selectedCollectDetails = $local->collectDetails;
            $selectedAuxMoneyStorage = $local->auxmoneystorageinfo;
        }

        // Calcular datos basados en los datos filtrados o completos
        $totalRecicladores = Collect::totalRecicladores($selectedCollects);
        $totalPagadores = Collect::totalPagadores($selectedCollects);
        $totalMultimoneda = Collect::totalMultimoneda($selectedCollects);
        $dineroActivo = Collect::dineroActivo($selectedCollects);
        $totalApiladores = Collect::totalApiladores($selectedCollects);
        $totalRechazoDispensador = Collect::totalRechazoDispensador($selectedCollects);
        $totalCajones = Collect::totalCajones($selectedCollects);
        $totalCajonesVirtuales = Collect::totalCajonesVirtuales($selectedCollects);
        $dineroNoActivo = Collect::dineroNoActivo($selectedCollects);
        $arqueoTotal = Collect::arqueoTotal($selectedCollects);

        $dataCollects = [
            'totalRecicladores' => (string) $totalRecicladores,
            'totalPagadores' => (string) $totalPagadores,
            'totalMultimoneda' => (string) $totalMultimoneda,
            'dineroActivo' => (string) $dineroActivo,
            'totalApiladores' => (string) $totalApiladores,
            'totalRechazoDispensador' => (string) $totalRechazoDispensador,
            'totalCajones' => (string) $totalCajones,
            'totalCajonesVirtuales' => (string) $totalCajonesVirtuales,
            'dineroNoActivo' => (string) $dineroNoActivo,
            'arqueoTotal' => (string) $arqueoTotal,
        ];

        $orderedCollectionJson = Collect::colocarCampos($selectedCollects);
        $collectOrdenado = json_decode($orderedCollectionJson);

        $calculoCollectDetails50 = Collectdetail::valoresParaCollectDetails50($selectedCollectDetails);
        $principalDisponible = Collectdetail::disponible($selectedCollectDetails);
        $apuestas = Collectdetail::apuestas($selectedCollectDetails);
        $disponible = Collectdetail::disponible($selectedCollectDetails);
        $auxiliares = Collectdetail::auxiliares($selectedCollectDetails);

        $dataCollectDetails = [
            'calculoCollectDetails50' => $calculoCollectDetails50,
            'apuestas' => $apuestas->values()->all(),
            'disponible' => $disponible->values()->all(),
            'auxiliares' => $auxiliares->values()->all(),
        ];

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

        $ticketsRaros = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('Status', 'MANUALLY VALIDATED')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                DB::raw('NOW()'),
            ])
            ->get();

        $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);

        $ticketsFilterAnterior = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                DB::raw('CURRENT_DATE - INTERVAL \'15 days\''),
                DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
            ])
            ->get();

        $totalTicketsSegunTipoDiaAnterior = Ticket::totalTickectsSegunTipo($ticketsFilterAnterior);

        $now = Carbon::now();
        $startOfDay = $now->copy()->startOfDay();

        $ticketsFilterActual = Ticket::where('local_id', $local->id)
            ->where('Command', 'CLOSE')
            ->where('TypeIsAux', 0)
            ->where('TypeIsBets', '!=', 1)
            ->where('Status', 'IN STACKER')
            ->whereBetween('LastCommandChangeDateTime', [
                $startOfDay,
                $now,
            ])
            ->get();

        $totalTicketsSegunTipoDiaActual = Ticket::totalTickectsSegunTipo($ticketsFilterActual);

        $ticketsData = json_decode($totalTicketsSegunTipo);
        $ticketRarosData = json_decode($ticketsRaros);
        $ticketsDataAnterior = json_decode($totalTicketsSegunTipoDiaAnterior);
        $ticketsDataActual = json_decode($totalTicketsSegunTipoDiaActual);

        $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
        $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

        $logs = $this->logs($id, $local->idMachines);

        return view('info.show', compact(
            'local',
            'dataCollects',
            'dataCollectDetails',
            'ticketsData',
            'collectOrdenado',
            'updatesObject',
            'ticketsFilter',
            'logs',
            'ticketRarosData',
            'ticketsDataAnterior',
            'ticketsDataActual',
            'todayName',
            'yesterdayName',
            'selectedUserMoney',
            'countSelect'
        ));
    }*/





    public function verificarCambios($id)
    {
        //dd($id);
        $ultimaModificacionCollectsInfo = CollectInfo::where('local_id', $id)->first();
        $ultimaModificacionauxmoneystorageinfo = AuxmoneystorageInfo::where('local_id', $id)->first();



        //dd($ultimaModificacionCollectsInfo[0]->LastUpdateDateTime);

        $respuesta = [
            'collectUpdate' => $ultimaModificacionCollectsInfo->LastUpdateDateTime,
            'auxmoneystorageinfo' => $ultimaModificacionauxmoneystorageinfo->LastUpdateDateTime,
        ];

        return response()->json($respuesta);
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

    private function getAuxName($local_id, $typeIsAux, $fechaLog)
    {
        $aux = Auxmoneystorage::select("AuxName")
            ->where("local_id", $local_id)
            ->where("TypeIsAux", $typeIsAux)
            ->where("created_at", '<=', $fechaLog)
            ->orderby('created_at', 'desc')
            ->first();

        /*$aux = Auxmoneystorage::select("AuxName")
            ->where("local_id", $local_id)
            ->where("TypeIsAux", $typeIsAux)
            ->where("updated_at","<=",$fechaLog)
            ->first();

        if(is_null($aux)){
            //echo "entra<br>";
            $aux = DB::table('auxmoneystoragehist')
            ->where("local_id", $local_id)
            ->where("TypeIsAux", $typeIsAux)
            ->where("created_at",">=",$fechaLog)
            ->orderBy("created_at", "asc")
            ->first();
        }*/

        return $aux ? $aux->AuxName : "Unknown";
    }


    public function logs($id, $idMachine)
    {
        $agent = new Agent();

        $logs = Logs::select('Type', 'Text', 'DateTime', 'User')
            ->where('local_id', $id)
            ->where('User', '!=', 'pc')
            ->where('User', '!=', $idMachine)
            ->where('User', '!=', 'fran')
            ->where('User', '!=', 'CCM')
            ->where('Type', '!=', 'movementTicket')
            ->where('Type', '!=', 'log')
            ->where('Type', '!=', 'error')
            ->where('Type', '!=', 'warning')
            ->whereBetween('DateTime', [
                DB::raw("NOW() - INTERVAL '3 DAY'"),
                DB::raw('NOW()')
            ])
            ->orderBy('DateTime', 'DESC')
            ->get();


        /*$logs = DB::connection(nuevaConexion($id))->table('logs')
            ->select('Type', 'Text', 'DateTime', 'User')
            ->where('User', '!=', 'pc')
            ->where('User', '!=', $idMachine)
            ->where('User', '!=', 'fran')
            ->where('User', '!=', 'CCM')
            ->where('Type', '!=', 'movementTicket')
            ->where('Type', '!=', 'log')
            ->where('Type', '!=', 'error')
            ->where('Type', '!=', 'warning')
            ->whereBetween('DateTime', [
                DB::raw('DATE_SUB(NOW(), INTERVAL 2 DAY)'),
                DB::raw('NOW()')
            ])
            ->orderBy('DateTime', 'DESC')
            ->get();*/


        $logsEs = [];
        foreach ($logs as $log) {
            $traduccion = [
                "doorClosed" => "Puerta cerrada",
                "doorOpened" => "Puerta abierta",
                "error" => "Error",
                "log" => "Evento",
                "movementBalanceCollectByBets" => "Recaudación de apuestas",
                "movementBalanceTransferByBets" => "Transferencia desde apuestas",
                "movementChange" => "Cambios",
                "movementChangeByBets" => "Resumen de lo pagado por apuestas",
                "movementChangeByBets00" => "Resumen de lo pagado por apuestas",
                "movementChangeByBets01" => "Resumen de lo pagado por apuestas",
                "movementChangeByBets02" => "Resumen de lo pagado por apuestas",
                "movementChangeByBets03" => "Resumen de lo pagado por apuestas",
                "movementChangeMoneyStorage1" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage100" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage101" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage102" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage103" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage2" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage200" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage201" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage202" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage203" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage3" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage300" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage301" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage302" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage303" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage4" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage400" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage401" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage402" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage403" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage5" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage500" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage501" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage502" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage503" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage6" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage600" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage601" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage602" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage603" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage7" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage700" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage701" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage702" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage703" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage8" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage800" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage801" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage802" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage803" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage9" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage900" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage901" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage902" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage903" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage10" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage1000" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage1001" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage1002" => "Resumen de lo pagado por auxiliares",
                "movementChangeMoneyStorage1003" => "Resumen de lo pagado por auxiliares",
                "movementEmptyCashbox" => "Vaciado de cajón",
                "movementEmptyMoneyStorage1" => "Recaudación " . $this->getAuxName($id, 1, $log->DateTime),
                "movementEmptyMoneyStorage10" => "Recaudación " . $this->getAuxName($id, 10, $log->DateTime),
                "movementEmptyMoneyStorage2" => "Recaudación " . $this->getAuxName($id, 2, $log->DateTime),
                "movementEmptyMoneyStorage3" => "Recaudación " . $this->getAuxName($id, 3, $log->DateTime),
                "movementEmptyMoneyStorage4" => "Recaudación " . $this->getAuxName($id, 4, $log->DateTime),
                "movementEmptyMoneyStorage5" => "Recaudación " . $this->getAuxName($id, 5, $log->DateTime),
                "movementEmptyMoneyStorage6" => "Recaudación " . $this->getAuxName($id, 6, $log->DateTime),
                "movementEmptyMoneyStorage7" => "Recaudación " . $this->getAuxName($id, 7, $log->DateTime),
                "movementEmptyMoneyStorage8" => "Recaudación " . $this->getAuxName($id, 8, $log->DateTime),
                "movementEmptyMoneyStorage9" => "Recaudación " . $this->getAuxName($id, 9, $log->DateTime),
                "movementEmptyPuloon" => "Vaciado del puloon",
                "movementEmptyPuloonReject" => "Vaciado rechazo puloon",
                "movementEmptyStacker" => "Vaciado de apilador",
                "movementEmptyStackerByBets" => "Recaudación desde apilador para apuestas",
                "movementEmptyStackerMoneyStorage1" => "Recaudación desde apilador para " . $this->getAuxName($id, 1, $log->DateTime),
                "movementEmptyStackerMoneyStorage2" => "Recaudación desde apilador para " . $this->getAuxName($id, 2, $log->DateTime),
                "movementEmptyStackerMoneyStorage3" => "Recaudación desde apilador para " . $this->getAuxName($id, 3, $log->DateTime),
                "movementEmptyStackerMoneyStorage4" => "Recaudación desde apilador para " . $this->getAuxName($id, 4, $log->DateTime),
                "movementEmptyStackerMoneyStorage5" => "Recaudación desde apilador para " . $this->getAuxName($id, 5, $log->DateTime),
                "movementEmptyStackerMoneyStorage6" => "Recaudación desde apilador para " . $this->getAuxName($id, 6, $log->DateTime),
                "movementEmptyStackerMoneyStorage7" => "Recaudación desde apilador para " . $this->getAuxName($id, 7, $log->DateTime),
                "movementEmptyStackerMoneyStorage8" => "Recaudación desde apilador para " . $this->getAuxName($id, 8, $log->DateTime),
                "movementEmptyStackerMoneyStorage9" => "Recaudación desde apilador para " . $this->getAuxName($id, 9, $log->DateTime),
                "movementEmptyStackerMoneyStorage10" => "Recaudación desde apilador para " . $this->getAuxName($id, 10, $log->DateTime),
                "movementRefill" => "Recargas",
                "movementRefillByBets" => "Recarga de apuestas",
                "movementRefillHardCash1" => "Recargas Cajón Virtual 1",
                "movementRefillHardCash2" => "Recargas Cajón Virtual 2",
                "movementRefillHardCash3" => "Recargas Cajón Virtual 3",
                "movementRefillHardCash4" => "Recargas Cajón Virtual 4",
                "movementRefillHardCash5" => "Recargas Cajón Virtual 5",
                "movementRefillMoneyStorage1" => "Recarga " . $this->getAuxName($id, 1, $log->DateTime),
                "movementRefillMoneyStorage2" => "Recarga " . $this->getAuxName($id, 2, $log->DateTime),
                "movementRefillMoneyStorage3" => "Recarga " . $this->getAuxName($id, 3, $log->DateTime),
                "movementRefillMoneyStorage4" => "Recarga " . $this->getAuxName($id, 4, $log->DateTime),
                "movementRefillMoneyStorage5" => "Recarga " . $this->getAuxName($id, 5, $log->DateTime),
                "movementRefillMoneyStorage6" => "Recarga " . $this->getAuxName($id, 6, $log->DateTime),
                "movementRefillMoneyStorage7" => "Recarga " . $this->getAuxName($id, 7, $log->DateTime),
                "movementRefillMoneyStorage8" => "Recarga " . $this->getAuxName($id, 8, $log->DateTime),
                "movementRefillMoneyStorage9" => "Recarga " . $this->getAuxName($id, 9, $log->DateTime),
                "movementRefillMoneyStorage10" => "Recarga " . $this->getAuxName($id, 10, $log->DateTime),
                "movementUnload" => "Vaciados",
                "movementUnloadByBets" => "Vaciado por apuestas",
                "movementCount" => "Conteos",
                "movementResetManualTickets" => "Borrado de tickets mediante teclado",
                "movementTicket" => "Ticket creado",
                "powerOff" => "Apagado",
                "powerOn" => "Encendido",
                "printerNotConnected" => "Impresora no conectada",
                "printerNotWorking" => "Impresora no funcional",
                "printerOutOfPaper" => "Impresora sin papel",
                "printError" => "Error de impresión",
                "printLine" => "Línea impresa",
                "start" => "Inicio",
                "warning" => "Aviso"
            ];

            $cantidad = 0;
            $total = 0;

            if ($log->Type == "movementBalanceCollectByBets") {
                //dd($log->Text);
                $total;
                $partsTotal = explode("|", $log->Text);

                if ($partsTotal > 0) {
                    $total = $partsTotal[1];
                    $valorTotal = explode(":", $total);
                    $log->Text = "Recaudación = " . $valorTotal[1] . "€<br><br>Extración de tickets:<br>";

                    $tickets = explode(':', $partsTotal[0]);
                    $ticketSep = explode("-", $tickets[1]);
                    foreach ($ticketSep as $frase) {
                        $res = explode("x", $frase);
                        if (isset($res[1]) && strpos($res[1], "T3") !== 0) {
                            $nTicket = substr($res[1], 1);

                            $ticket = Ticket::select("Type", "Comment", "User", "DateTime", "Value")
                                ->where("TicketNumber", $nTicket)
                                ->first();
                            /*$ticket = DB::connection($connectionName)->table('tickets')
                                ->select("Type","Comment","User","DateTime","Value")
                                ->where("TicketNumber", "=", $nTicket)
                                ->first();*/

                            if ($ticket) {
                                if ($ticket->Type == "DATAFONO") {
                                    $log->Text .= "Ticket " . $cantidad . "€ - " . $ticket->Type . " - " . $ticket->Comment . " - " . $ticket->User . " - " . $ticket->DateTime . "<br>";
                                } else {
                                    $log->Text .= "Ticket " . $cantidad . "€ - " . $ticket->Type . " - " . $ticket->Comment . " - " . $ticket->User . "<br>";
                                }
                            }
                        }
                    }
                }
            } elseif (strpos($log->Type, "Refill") !== false) {
                $datos = explode(":", $log->Text);

                $cantVal = explode("-", $datos[1]);
                $log->Text = "Entradas:<br>";
                foreach ($cantVal as $i) {
                    if ($i != "OUT") {
                        $partCantVal = explode("x", $i);
                        if ($partCantVal > 0) {
                            $cantidad = $partCantVal[0];
                            $valor = $partCantVal[1];

                            $valorNumerico = preg_replace('/[^0-9.,]/', '', $valor);
                            $valorNumerico = str_replace(',', '.', $valorNumerico);

                            if ($valor[0] == "C") {
                                $log->Text .= $cantidad . " monedas de " . $valorNumerico . "€ = " . ($cantidad * $valorNumerico) . "€<br>";
                            } elseif ($valor[0] == "N") {
                                $log->Text .= $cantidad . " billetes de " . $valorNumerico . "€ = " . ($cantidad * $valorNumerico) . "€<br>";
                            }
                        }
                    }
                }
                $log->Text .= "<br>Total: " . end($datos) . "€";
            } elseif (strpos($log->Type, "movementUnload") !== false || strpos($log->Type, "movementEmptyStacker") !== false || strpos($log->Type, "movementEmptyMoneyStorage") !== false || strpos($log->Type, "movementEmptyPuloon") !== false || strpos($log->Type, "movementResetManualTickets") !== false || strpos($log->Type, "movementEmptyCashbox") !== false) {
                $datos = explode("|", $log->Text);
                $valores = explode(":", $datos[0]);
                $valorTotal = explode(":", $datos[1]);
                if (strpos($log->Type, "movementUnload") !== false) {
                    $log->Text = "Salidas:<br>";
                } elseif (strpos($log->Type, "movementEmptyStacker") !== false) {
                    $log->Text = "Extracción de tickets o billetes:<br>";
                } elseif (strpos($log->Type, "movementEmptyMoneyStorage") !== false) {
                    $log->Text = "Recaudación = " . $valorTotal[1] . "€<br><br>Extracción de tickets:<br>";
                } elseif (strpos($log->Type, "movementEmptyPuloon") !== false) {
                    $log->Text = "Extracción Puloon:<br>";
                } elseif (strpos($log->Type, "movementResetManualTickets") !== false) {
                    $log->Text = "Borrado de tickets = " . $valorTotal[1] . "€<br><br>Extracción de tickets:<br>";
                } elseif (strpos($log->Type, "movementEmptyCashbox") !== false) {
                    $log->Text = "Vaciado de cajón: <br>";
                }

                $valoresArray = explode("-", $valores[1]);
                $arrayTickets = [];
                $ticketNumbers = [];

                if (!$agent->isMobile()) {
                    foreach ($valoresArray as $i) {
                        $partCantVal = explode("x", $i);
                        if (count($partCantVal) > 1) {
                            $valor = $partCantVal[1];
                            if ($valor[0] == 'T') {
                                $ticketNumbers[] = substr($valor, 1);
                            }
                        }
                    }

                    if (!empty($ticketNumbers)) {

                        $tickets = Ticket::select("TicketNumber", "Type", "Comment", "User", "DateTime", "Value")
                            ->whereIn("TicketNumber", $ticketNumbers)
                            ->get()
                            ->keyBy('TicketNumber');

                        /*$tickets = DB::connection($connectionName)->table('tickets')
                            ->select("TicketNumber", "Type", "Comment", "User", "DateTime", "Value")
                            ->whereIn("TicketNumber", $ticketNumbers)
                            ->get()
                            ->keyBy('TicketNumber');*/
                    }
                }

                foreach ($valoresArray as $i) {
                    $partCantVal = explode("x", $i);
                    if (count($partCantVal) > 1) {
                        $cantidad = $partCantVal[0];
                        $valor = $partCantVal[1];

                        if ($valor[0] == 'C' || $valor[0] == 'N') {
                            $valorNumerico = preg_replace('/[^0-9.,]/', '', $valor);
                            $valorNumerico = str_replace(',', '.', $valorNumerico);

                            $cantidad = (float)$cantidad;
                            $valorNumerico = (float)$valorNumerico;

                            if ($valor[0] == "C") {
                                $log->Text .= $cantidad . " monedas de " . $valorNumerico . "€ = " . ($cantidad * $valorNumerico) . "€<br>";
                            } elseif ($valor[0] == "N") {
                                $log->Text .= $cantidad . " billetes de " . $valorNumerico . "€ = " . ($cantidad * $valorNumerico) . "€<br>";
                            }
                        } else {
                            if (!$agent->isMobile()) {
                                if ($valor[0] == 'T') {
                                    $nTicket = substr($valor, 1);
                                    $ticket = $tickets[$nTicket] ?? null;

                                    if ($ticket) {
                                        if ($ticket->Type == "test") {
                                            if (array_key_exists($ticket->Comment, $arrayTickets)) {
                                                $arrayTickets[$ticket->Comment] += $ticket->Value;
                                            } else {
                                                $arrayTickets[$ticket->Comment] = $ticket->Value;
                                            }
                                        } else {
                                            if (array_key_exists($ticket->Type, $arrayTickets)) {
                                                $arrayTickets[$ticket->Type] += $ticket->Value;
                                            } else {
                                                $arrayTickets[$ticket->Type] = $ticket->Value;
                                            }
                                        }

                                        if ($ticket->Type == "DATAFONO") {
                                            $log->Text .= "Ticket " . $cantidad . "€ - " . $ticket->Type . " - " . $ticket->Comment . " - " . $ticket->User . " - " . $ticket->DateTime . "<br>";
                                        } else {
                                            $log->Text .= "Ticket " . $cantidad . "€ - " . $ticket->Type . " - " . $ticket->Comment . " - " . $ticket->User . "<br>";
                                        }
                                    }
                                } else {
                                    $log->Text .= "Ticket " . $cantidad . "€ - " . $valor . "<br>";
                                }
                            }
                        }
                    }
                }

                if ($arrayTickets) {
                    foreach ($arrayTickets as $nombreLlave => $valor) {
                        $log->Text .= "<br>" . $nombreLlave . " : " . $valor . "€";
                    }
                    $log->Text .= "<br>";
                }

                $log->Text .= "<br>";
                if (strpos($log->Type, "movementUnload") !== false) {
                    $log->Text .= "Balance = " . $valorTotal[1] . "€";
                } elseif (strpos($log->Type, "movementEmptyStacker") !== false) {
                    $log->Text .= "Vaciado = " . $valorTotal[1] . "€";
                } elseif (strpos($log->Type, "movementEmptyPuloon") !== false || strpos($log->Type, "movementEmptyCashbox") !== false) {
                    $log->Text .= "Total = " . $valorTotal[1] . "€";
                }
            } elseif (strpos($log->Type, "movementChangeMoneyStorage") !== false | strpos($log->Type, "movementChangeByBets") !== false) {
                $datos = explode("|", $log->Text);
                $valorEntradas = explode(":", $datos[0]);
                $listaVal = explode("-", $valorEntradas[1]);
                $log->Text = "";

                foreach ($listaVal as $val) {
                    $partCantVal = explode("x", $val);
                    if (count($partCantVal) > 1) {
                        $cantidad = $partCantVal[0];
                        $valor = $partCantVal[1];

                        if ($valor[0] == 'C' | $valor[0] == 'N') {
                            $valorNumerico = preg_replace('/[^0-9.,]/', '', $valor);
                            $valorNumerico = str_replace(',', '.', $valorNumerico);

                            $cantidad = (float)$cantidad;
                            $valorNumerico = (float)$valorNumerico;

                            $log->Text .= "Rellenado con = " . ($cantidad * $valorNumerico) . "€<br>";
                        } elseif ($valor[0] == 'T') {
                            $valorNumerico = preg_replace('/[^0-9.,]/', '', $valor);
                            $valorNumerico = str_replace(',', '.', $valorNumerico);

                            $number = $valorNumerico / 100;

                            $log->Text .= "Recarga " . $this->getAuxName($id, $number, $log->DateTime) . " = " . $cantidad . "€<br>";
                        }
                    }
                }

                $valorSalidas = explode(":", $datos[1]);
                $listaValSal = explode("-", $valorSalidas[1]);
                $log->Text .= "<br>Total desglosado:<br>";
                foreach ($listaValSal as $val) {
                    $partCantVal = explode("x", $val);
                    if (count($partCantVal) > 1) {
                        $cantidad = $partCantVal[0];
                        $valor = $partCantVal[1];

                        if ($valor[0] == 'C' | $valor[0] == 'N' | $valor[0] == 'O') {
                            $valorNumerico = preg_replace('/[^0-9.,]/', '', $valor);
                            $valorNumerico = str_replace(',', '.', $valorNumerico);

                            $cantidad = (float)$cantidad;
                            $valorNumerico = (float)$valorNumerico;

                            if ($valor[0] == 'C') {
                                $log->Text .= $cantidad . " monedas de " . $valorNumerico . "€<br>";
                            } elseif ($valor[0] == 'N') {
                                $log->Text .= $cantidad . " billetes de " . $valorNumerico . "€<br>";
                            } elseif ($valor[0] == 'O') {
                                $log->Text .= ($valorNumerico * 100) . " céntimos<br>";
                            }
                        }
                    }
                }

                $totalTexto = explode(":", $datos[2]);
                $log->Text .= "<br>Total pagado = " . $totalTexto[1] . "€<br>";
            }

            $tipoTraducido = isset($traduccion[$log->Type]) ? $traduccion[$log->Type] : $log->Type;
            $log->Type = $tipoTraducido;
            $logsEs[] = $log;
        }

        return $logsEs;
    }
}
