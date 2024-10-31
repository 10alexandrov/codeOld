<?php

namespace App\Http\Controllers;

use App\Models\Delegation;
use App\Models\TypeMachines;
use App\Models\Local;
use App\Models\ConfigMC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TypeMachinesController extends Controller
{
    /* public function showTypesMachines($id)
    {
        $delegation = Delegation::with('zones.locals.type_machines')->find($id);
        $types = $delegation->typeMachines;
        $types = $types->sortBy('name');
        return view('TypesMachines.index', compact('types', 'delegation'));
    }*/

    public function showTypesMachines($id)
    {
        $delegation = Delegation::with('zones.locals.type_machines')->find($id);
        $types = $delegation->typeMachines()->paginate(16); // Adjust the number '10' to your desired items per page
        return view('TypesMachines.index', compact('types', 'delegation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $delegation = Delegation::with('zones.locals')->find($id);
        //dd($delegation);
        return view('TypesMachines.create', compact('delegation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'delegation_id' => 'required|exists:delegations,id',
            'locales' => 'required|array',
            'locales.*' => 'exists:locals,id',
        ]);

        // Crear el nuevo tipo de máquina
        $typeMachine = TypeMachines::create([
            'name' => $validated['name'],
        ]);

        // Asignar el tipo de máquina a la delegación
        DB::table('type_machines_delegations')->insert([
            'type_machine_id' => $typeMachine->id,
            'delegation_id' => $validated['delegation_id'],
        ]);

        // Asignar el tipo de máquina a los locales
        foreach ($validated['locales'] as $localId) {
            DB::table('type_machines_local')->insert([
                'type_machine_id' => $typeMachine->id,
                'local_id' => $localId,
            ]);
        }

        // Obtener la delegación con las relaciones necesarias
        $delegation = Delegation::with('zones.locals.type_machines')
            ->find($validated['delegation_id']);

        // Obtener los tipos de máquinas y ordenarlos por nombre
        $types = $delegation->typeMachines->sortBy('name');

        //recorrer los locales para ver cual tiene asociados el typeMachine
        foreach ($request->locales as $local_id) {

            //crear tickets ABORT para meter el tipo nuevo creado en la maquina azul
            $config = ConfigMC::where('local_id', $local_id)->first();
            //dd($config);
            //Array de datos para crear el ticket
            $insertData = [
                'Command' => 'ABORT',
                'TicketNumber' => GenerateNewNumberFormat($config->NumberOfDigits),
                'Mode' => 'webPost',
                'DateTime' => now(),
                'LastCommandChangeDateTime' => now(),
                'LastIP' => getRealIpAddr(),
                'LastUser' => 'Prometeo',
                'Value' => 1,
                'Residual' => 0,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo',
                'Comment' => 'Creado mediante prometeo',
                'Type' => $request->name,
                'TypeIsBets' => 0,
                'TypeIsAux' => 1,
                'HideOnTC' => 0,
                'Used' => 0,
                'TITOExpirationType' => 0,
            ];

            DB::connection(nuevaConexion($local_id))->table('tickets')->insert($insertData);
        }
        // Redirigir al index con los datos necesarios
        return view('TypesMachines.index', compact('types', 'delegation'));
    }


    /**
     * Display the specified resource.
     */
    public function show(TypeMachines $typeMachines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit($id)
    {
        // Buscar el TypeMachine por su id
        $typeMachine = TypeMachines::findOrFail($id);

        // Obtener la delegación a la que está asociada la máquina
        $delegation = $typeMachine->delegation()->first(); // Ajusta según la relación real

        // Obtener los locales asociados a la máquina
        $locals = $typeMachine->local; // Cambiado a 'local' en lugar de 'locals' para coincidir con el nombre del método
        //dd($locals);
        // Devolver la vista de edición con los datos necesarios
        return view('TypesMachines.edit', compact('typeMachine', 'delegation', 'locals'));
    }*/

    public function edit($id)
    {
        // Buscar el TypeMachine por su id con relaciones necesarias
        $typeMachine = TypeMachines::with('locals', 'delegation.zones.locals')->findOrFail($id);

        // Obtener la primera (o única) delegación asociada
        $delegation = $typeMachine->delegation->first(); // Usar first() para obtener el primer resultado

        // Verificar si la delegación está disponible
        if (!$delegation) {
            abort(404, 'Delegación no encontrada.');
        }

        // Obtener los locales asociados a la máquina
        $locals = $typeMachine->locals;

        // Devolver la vista de edición con los datos necesarios
        return view('TypesMachines.edit', compact('typeMachine', 'delegation', 'locals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'locals' => 'array',
            'locals.*' => 'exists:locals,id',  // Verifica que cada local ID exista en la tabla de locales
            'delegation_id' => 'required|exists:delegations,id',  // Verifica que el delegation_id sea válido
        ]);

        // Buscar el TypeMachine por su id
        $typeMachine = TypeMachines::findOrFail($id);

        $localesAntAsoc = $typeMachine->locals->pluck('id')->toArray();
        $localesSeleccionados = $request->input('locals', []);


        $localesDesasociados = array_diff($localesAntAsoc, $localesSeleccionados);
        //dd($localesDesasociados);
        foreach ($localesDesasociados as $local_id) {
            $fechaLimite = Carbon::now()->subMonths(6);
            //dd($fechaLimite);
            DB::connection(nuevaConexion($local_id))
                ->table('tickets')
                ->where('Type', $typeMachine->name)
                ->where('DateTime', '<=', $fechaLimite)
                ->delete();
        }

        // Actualizar el nombre del tipo de máquina
        $typeMachine->name = $validated['name'];
        $typeMachine->save();

        $localesCoincidentes = array_intersect($localesAntAsoc, $localesSeleccionados);
        foreach ($localesCoincidentes as $local_id) {
            $config = ConfigMC::where('local_id', $local_id)->first();
            DB::connection(nuevaConexion($local_id))->table('tickets')->insert([
                'Command' => 'ABORT',
                'TicketNumber' => GenerateNewNumberFormat($config->NumberOfDigits),
                'Mode' => 'webPost',
                'DateTime' => now(),
                'LastCommandChangeDateTime' => now(),
                'LastIP' => getRealIpAddr(),
                'LastUser' => 'Prometeo',
                'Value' => 1,
                'Residual' => 0,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo',
                'Comment' => 'Creado mediante prometeo',
                'Type' => $typeMachine->name,
                'TypeIsBets' => 0,
                'TypeIsAux' => 1,
                'HideOnTC' => 0,
                'Used' => 0,
                'TITOExpirationType' => 0,
            ]);
        }

        $localesAsociados = array_diff($localesSeleccionados, $localesAntAsoc);
        foreach ($localesAsociados as $local_id) {
            $config = ConfigMC::where('local_id', $local_id)->first();
            //dd($config);
            DB::connection(nuevaConexion($local_id))->table('tickets')->insert([
                'Command' => 'ABORT',
                'TicketNumber' => GenerateNewNumberFormat($config->NumberOfDigits),
                'Mode' => 'webPost',
                'DateTime' => now(),
                'LastCommandChangeDateTime' => now(),
                'LastIP' => getRealIpAddr(),
                'LastUser' => 'Prometeo',
                'Value' => 1,
                'Residual' => 0,
                'IP' => getRealIpAddr(),
                'User' => 'Prometeo',
                'Comment' => 'Creado mediante prometeo',
                'Type' => $typeMachine->name,
                'TypeIsBets' => 0,
                'TypeIsAux' => 1,
                'HideOnTC' => 0,
                'Used' => 0,
                'TITOExpirationType' => 0,
            ]);
        }

        // Sincronizar los locales asociados
        $typeMachine->locals()->sync($validated['locals']);

        // Obtener la delegación con las relaciones necesarias
        $delegation = Delegation::with('zones.locals.type_machines')
            ->find($validated['delegation_id']);

        // Obtener los tipos de máquinas y ordenarlos por nombre
        $types = $delegation->typeMachines->sortBy('name');

        // Redirigir a la vista de índice con los datos necesarios
        return view('TypesMachines.index', compact('types', 'delegation'));
    }

    /*public function update(Request $request, $id)
{
    // Validar los datos recibidos
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'locals' => 'required|array',
        'locals.*' => 'integer|exists:locals,id',
        'delegation_id' => 'required|integer|exists:delegations,id',
    ]);

    // Buscar el TypeMachine por su id
    $typeMachine = TypeMachines::findOrFail($id);

    // Actualizar los atributos del TypeMachine
    $typeMachine->update([
        'name' => $validated['name'],
        'delegation_id' => $validated['delegation_id'],
    ]);

    // Sincronizar los locales asociados a la máquina en la tabla pivote
    $typeMachine->local()->sync($validated['locals']);

    // Obtener la delegación con las relaciones necesarias para redirigir a la vista index
    $delegation = Delegation::with('zones.locals.type_machines')
        ->find($validated['delegation_id']);

    // Obtener los tipos de máquinas y ordenarlos por nombre
    $types = $delegation->typeMachines->sortBy('name');

    // Redirigir a la vista de índice con un mensaje de éxito
    return view('TypesMachines.index', compact('types', 'delegation'))
        ->with('success', 'Tipo de máquina actualizado correctamente.');
}*/



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $typeMachine = TypeMachines::find($id);
        //dd($typeMachine);

        $delegation = $typeMachine->delegation()->first();
        //dd($delegation->id);
        $typeMachine->delete();

        // Obtener la delegación con las relaciones necesarias
        $delegation = Delegation::with('zones.locals.type_machines')
            ->find($delegation->id);

        // Obtener los tipos de máquinas y ordenarlos por nombre
        $types = $delegation->typeMachines->sortBy('name');

        // Redirigir a la vista de índice con los datos necesarios
        return view('TypesMachines.index', compact('types', 'delegation'));
    }

    public function destroyAll($id)
    {
        $typeMachine = TypeMachines::find($id);
        $delegation = $typeMachine->delegation()->with('zones.locals')->first();
        $locales = [];

        foreach ($delegation->zones as $zone) {
            foreach ($zone->locals as $locale) {
                $locales[] = $locale;
            }
        }

        foreach ($locales as $local) {
            try {
                $fechaLimite = Carbon::now()->subMonths(6);

                DB::connection(nuevaConexion($local->id))
                    ->table('tickets')
                    ->where('Type', $typeMachine->name)
                    ->where('DateTime', '<=', $fechaLimite)
                    ->delete();
            } catch (\Exception $e) {
                $errores[] = "Error al eliminar en la conexión {$local->name}";
            }
        }

        $typeMachine->delete();

        // Obtener la delegación con las relaciones necesarias
        $delegation = Delegation::with('zones.locals.type_machines')
            ->find($delegation->id);

        // Obtener los tipos de máquinas y ordenarlos por nombre
        $types = $delegation->typeMachines->sortBy('name');

        // Redirigir a la vista de índice con los datos necesarios
        return view('TypesMachines.index', compact('types', 'delegation'));
    }

    /*public function showSyncTypeMachines($id)
    {
        $delegation = Delegation::with('zones.locals.type_machines')->find($id);
        $types = $delegation->typeMachines;
        //dd($types);
        $types = $types->sortBy('name');
        return view("TypesMachines.syncTypes", compact('delegation', 'types'));
    }*/

    public function showSyncTypeMachines(Request $request, $id)
    {
        $delegation = Delegation::with(['zones.locals.type_machines'])->find($id);

        $localId = $request->input('local_id');

        if ($localId) {
            $types = $delegation->zones->flatMap(function ($zone) use ($localId) {
                return $zone->locals->find($localId)->type_machines;
            })->unique('id')->sortBy('name');
        } else {
            $types = $delegation->typeMachines->sortBy('name');
        }

        $locals = $delegation->zones->flatMap(function ($zone) {
            return $zone->locals;
        });

        return view("TypesMachines.syncTypes", compact('delegation', 'types', 'locals'));
    }

    public function syncTypeMachines(Request $request)
    {
        try {
            foreach ($request->locals as $local_id) {
                $local = Local::find($local_id);

                foreach ($request->types as $type_id) {
                    $type = TypeMachines::find($type_id);
                    $local->type_machines()->syncWithoutDetaching([$type_id]);

                    $config = ConfigMC::where('local_id', $local_id)->first();
                    DB::connection(nuevaConexion($local_id))->table('tickets')->insert([
                        'Command' => 'ABORT',
                        'TicketNumber' => GenerateNewNumberFormat($config->NumberOfDigits),
                        'Mode' => 'webPost',
                        'DateTime' => now(),
                        'LastCommandChangeDateTime' => now(),
                        'LastIP' => getRealIpAddr(),
                        'LastUser' => 'Prometeo',
                        'Value' => 1,
                        'Residual' => 0,
                        'IP' => getRealIpAddr(),
                        'User' => 'Prometeo',
                        'Comment' => 'Creado mediante prometeo',
                        'Type' => $type->name,
                        'TypeIsBets' => 0,
                        'TypeIsAux' => 1,
                        'HideOnTC' => 0,
                        'Used' => 0,
                        'TITOExpirationType' => 0,
                    ]);
                }
            }

            return redirect()->route('showTypesMachines.index', $request->delegation_id);
        } catch (\Exception $e) {
            return redirect()->route('showTypesMachines.index', $request->delegation_id);
        }
    }

    public function search(Request $request, $delegationId)
    {
        // Obtiene el término de búsqueda del input
        $searchTerm = $request->input('search');
        $searchTerm = '%' . $searchTerm . '%'; // Ajuste para búsqueda parcial

        // Busca tipos de máquinas que están relacionados con la delegación dada
        $types = TypeMachines::whereHas('delegation', function ($query) use ($delegationId) {
            $query->where('delegation_id', $delegationId);
        })->where('name', 'Ilike', $searchTerm)
            ->paginate(16)
            ->appends(['search' => $request->input('search')]); // Asegura que el parámetro de búsqueda se mantenga en la paginación

        // Obtiene la delegación por su ID
        $delegation = Delegation::findOrFail($delegationId);

        // Manejo de solicitudes AJAX
        if ($request->ajax()) {
            return response()->json([
                'types' => view('partials.types', compact('types'))->render(),
                'pagination' => $types->links('pagination::bootstrap-4')->toHtml(),
            ]);
        }

        // Retorna la vista con los resultados de la búsqueda
        return view('TypesMachines.index', compact('types', 'delegation'));
    }
}
