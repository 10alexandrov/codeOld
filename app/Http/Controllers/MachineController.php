<?php

namespace App\Http\Controllers;

use App\Models\Delegation;
use App\Models\Local;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        try {
            $delegation = Delegation::findOrFail($id);
            $machines = $delegation->machines()->paginate(16);

            return view("machines.index", compact("machines", "delegation"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $delegation = Delegation::findOrFail($id);
        return view("machines.create", compact("delegation"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'alias' => ['required'],
            'model' => ['required'],
            'codigo' => ['required', 'regex:/^[A-Za-z0-9]{3}$/'],
            'serie' => ['required', 'regex:/^\d{2}( [A-Za-z]|[A-Za-z]{2})$/'],
            'numero' => ['required', 'digits:6'],
            //'local' => ['required'],
        ], [
            'name.required' => 'El nombre de la máquina es obligatorio.',
            'alias.required' => 'El alias de la máquina es obligatorio.',
            'model.required' => 'El modelo de la máquina es obligatorio.',
            'codigo.required' => 'El código de la máquina es obligatorio.',
            'codigo.regex' => 'El código debe ser una cadena de exactamente 3 caracteres alfanuméricos.',
            'serie.required' => 'La serie de la máquina es obligatoria.',
            'serie.regex' => 'La serie debe ser una cadena de 4 caracteres, con los primeros 2 siendo números y los últimos 2 siendo dos letras o un espacio seguido de una letra.',
            'numero.required' => 'El número de la máquina es obligatorio.',
            'numero.digits' => 'El número debe tener exactamente 6 dígitos.',
            //'local.required' => 'El local de la máquina es obligatorio.',
        ]);

        $local = explode(":", $request->local);
        $identificador = $request->model . ':' . $request->codigo . ':' . $request->serie . ':' . $request->numero;

        $machine = new Machine();
        $machine->identificador = $identificador;
        $machine->name = $request->name;
        $machine->alias = $request->alias;

        if ($local[0] == 'S') {
            $machine->local_id = $local[1];
        } elseif ($local[0] == 'B') {
            $machine->bar_id = $local[1];
        }

        $machine->delegation_id = $request->delegation_id;

        $machine->save();
        return redirect()->route('machines.index', $request->delegation_id);
        //dd($identificador);
    }

    /**
     * Display the specified resource.
     */
    public function show($local_id)
    {
        try {
            // Obtener el Local con sus máquinas y cargas
            $local = Local::with(['machines.loads'])->find($local_id);

            // Verificar si el local fue encontrado
            if (!$local) {
                abort(404, 'Local not found');
            }
            //dd($local);
            // Pasar los datos a la vista
            return view('machines.show', ['local' => $local]);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        $delegation = Delegation::findOrFail($machine->delegation_id);
        $identificador = explode(':', $machine->identificador);

        $mode = $identificador[0];
        $codigo = $identificador[1];
        $serie = $identificador[2];
        $numero = $identificador[3];


        return view('machines.edit', compact('machine', 'delegation', 'mode', 'codigo', 'serie', 'numero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'name' => ['required'],
            'alias' => ['required'],
            'model' => ['required'],
            'codigo' => ['required', 'regex:/^[A-Za-z0-9]{3}$/'],
            'serie' => ['required', 'regex:/^\d{2}( [A-Za-z]|[A-Za-z]{2})$/'],
            'numero' => ['required', 'digits:6'],
            //'local' => ['required'],
        ], [
            'name.required' => 'El nombre de la máquina es obligatorio.',
            'alias.required' => 'El alias de la máquina es obligatorio.',
            'model.required' => 'El modelo de la máquina es obligatorio.',
            'codigo.required' => 'El código de la máquina es obligatorio.',
            'codigo.regex' => 'El código debe ser una cadena de exactamente 3 caracteres alfanuméricos.',
            'serie.required' => 'La serie de la máquina es obligatoria.',
            'serie.regex' => 'La serie debe ser una cadena de 4 caracteres, con los primeros 2 siendo números y los últimos 2 siendo dos letras o un espacio seguido de una letra.',
            'numero.required' => 'El número de la máquina es obligatorio.',
            'numero.digits' => 'El número debe tener exactamente 6 dígitos.',
            //'local.required' => 'El local de la máquina es obligatorio.',
        ]);

        $local = explode(":", $request->local);
        $identificador = $request->model . ':' . $request->codigo . ':' . $request->serie . ':' . $request->numero;

        $machine->identificador = $identificador;
        $machine->name = $request->name;
        $machine->alias = $request->alias;

        if ($local[0] == 'S') {
            $machine->local_id = $local[1];
        } elseif ($local[0] == 'B') {
            $machine->bar_id = $local[1];
        }

        $machine->delegation_id = $request->delegation_id;

        $machine->save();
        return redirect()->route('machines.index', $request->delegation_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('machines.index', $machine->delegation_id);
    }

    public function search(Request $request, $delegationId)
    {
        // Obtiene el término de búsqueda del input
        $searchTerm = $request->input('search');
        $searchTerm = '%' . $searchTerm . '%'; // Ajuste para búsqueda parcial

        // Obtiene la delegación por su ID
        $delegation = Delegation::find($delegationId);

        // Busca máquinas relacionadas con la delegación dada, que coinciden con el término de búsqueda
        $machines = Machine::where('delegation_id', $delegationId)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'Ilike', $searchTerm)
                    ->orWhere('identificador', 'Ilike', $searchTerm)
                    ->orWhereHas('local', function ($q) use ($searchTerm) {
                        $q->where('name', 'Ilike', $searchTerm);
                    })
                    ->orWhereHas('bar', function ($q) use ($searchTerm) {
                        $q->where('name', 'Ilike', $searchTerm);
                    });
            })
            ->paginate(16)
            ->appends(['search' => $request->input('search')]); // Asegura que el parámetro de búsqueda se mantenga en la paginación

        // Retorna la vista con los resultados de la búsqueda
        return view("machines.index", compact("machines", "delegation"));
    }
}
