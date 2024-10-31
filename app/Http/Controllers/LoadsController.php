<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoadsController extends Controller
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
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'Number' => 'required|string|max:255',
            'Quantity' => 'required|numeric|min:0',
            'machine_id' => 'required|exists:machines,id',
        ]);

        // Crear una nueva instancia de Load y asignar los valores
        $load = new Load();
        $load->Number = $validatedData['Number'];
        $load->Quantity = $validatedData['Quantity'];
        $load->machine_id = $validatedData['machine_id'];
        $load->Created_for = auth()->user()->id; // Asigna el ID del usuario logueado
        $load->State = 'OPEN'; // El estado será siempre 'OPEN'

        // Asignar otros campos que pueden ser null
        $load->Partial_quantity = $request->input('Partial_quantity', null);
        $load->Irrecoverable = $request->has('Irrecoverable');
        $load->Initial = $request->has('Initial');
        $load->date_recovered = $request->input('date_recovered', null);

        $load->save();

        $machine = Machine::with('loads')->where('local_id', $request->local_id)->where('id', $load->machine_id)->first();

        // Verificar si se encontró la máquina
        if (!$machine) {
            abort(404, Lang::get('messages.machine_not_found'));
        }

        if ($machine->bar_id !== null) {
            return redirect()->route('loads.showBar', [$machine->bar_id, $machine->id]);
        } elseif ($machine->local_id !== null) {
            return redirect()->route('loads.showLocal', [$machine->local_id, $machine->id]);
        } else {
            return redirect('/')->with('success', Lang::get('messages.load_updated'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function showLocal($local_id, $machine_id)
    {
        $userTecnicos = User::role('Tecnico')->get();
        $user = auth()->user();

        // Obtener la máquina específica dentro del local
        $machine = Machine::with('loads')->where('local_id', $local_id)->where('id', $machine_id)->first();

        // Verificar si se encontró la máquina
        if (!$machine) {
            abort(404, Lang::get('messages.machine_not_found'));
        }

        // Obtener las cargas asociadas a la máquina específica
        $loads = Load::where('machine_id', $machine_id)->orderBy('created_at', 'desc')->get();

        // Calcular la suma de Quantity para los estados OPEN y PAID
        $totalOpenPaid = Load::where('machine_id', $machine_id)
            ->whereIn('State', ['OPEN', 'PAID'])
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->sum('Quantity');

        // Calcular la suma de Quantity para los estados RECOVERED y CLOSED
        $totalRecoveredClosed = Load::where('machine_id', $machine_id)
            ->whereIn('State', ['RECOVERED', 'CLOSED'])
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->sum('Quantity');

        // Calcular la suma de Quantity para el estado PARTIAL
        $totalPartial = Load::where('machine_id', $machine_id)
            ->where('State', 'PARTIAL')
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->get()
            ->reduce(function ($carry, $load) {
                return $carry + $load->Quantity - $load->Partial_quantity;
            }, 0);

        // Calcular la suma de Quantity para cargas Irrecuperables (pueden ser PARTIAL o CLOSED)
        $totalIrrecoverable = Load::where('machine_id', $machine_id)
            ->where('Irrecoverable', true)
            ->get()
            ->reduce(function ($carry, $load) {
                return $carry + $load->Quantity - $load->Partial_quantity;
            }, 0);

        // Calcular el total final restando totalRecoveredClosed de totalOpenPaid
        $totalQuantity = $totalOpenPaid - $totalRecoveredClosed;

        // Obtener los estados traducidos
        $states = config('messages.states');

        // Pasar los datos a la vista
        return view('loads.show', [
            'machine' => $machine,
            'loads' => $loads,
            'totalQuantity' => $totalQuantity, // Total calculado correctamente
            'totalPartial' => $totalPartial, // Suma de PARTIAL
            'totalIrrecoverable' => $totalIrrecoverable, // Suma de Irrecuperables
            'states' => $states,
            'user' => $user,
            'userTecnicos' => $userTecnicos
        ]);
    }

    public function showBar($bar_id, $machine_id)
    {
        $userTecnicos = User::role('Tecnico')->get();
        $user = auth()->user();

        // Obtener la máquina específica dentro del bar
        $machine = Machine::with('loads')->where('bar_id', $bar_id)->where('id', $machine_id)->first();

        // Verificar si se encontró la máquina
        if (!$machine) {
            abort(404, Lang::get('messages.machine_not_found'));
        }

        // Obtener las cargas asociadas a la máquina específica
        $loads = Load::where('machine_id', $machine_id)->orderBy('created_at', 'desc')->get();

        // Calcular la suma de Quantity para los estados OPEN y PAID
        $totalOpenPaid = Load::where('machine_id', $machine_id)
            ->whereIn('State', ['OPEN', 'PAID'])
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->sum('Quantity');

        // Calcular la suma de Quantity para los estados RECOVERED y CLOSED
        $totalRecoveredClosed = Load::where('machine_id', $machine_id)
            ->whereIn('State', ['RECOVERED', 'CLOSED'])
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->sum('Quantity');

        // Calcular la suma de Quantity para el estado PARTIAL
        $totalPartial = Load::where('machine_id', $machine_id)
            ->where('State', 'PARTIAL')
            ->where('Initial', false)
            ->where('Irrecoverable', false)
            ->get()
            ->reduce(function ($carry, $load) {
                return $carry + $load->Quantity - $load->Partial_quantity;
            }, 0);

        // Calcular la suma de Quantity para cargas Irrecuperables (pueden ser PARTIAL o CLOSED)
        $totalIrrecoverable = Load::where('machine_id', $machine_id)
            ->where('Irrecoverable', true)
            ->get()
            ->reduce(function ($carry, $load) {
                return $carry + $load->Quantity - $load->Partial_quantity;
            }, 0);

        // Calcular el total final restando totalRecoveredClosed de totalOpenPaid
        $totalQuantity = $totalOpenPaid - $totalRecoveredClosed;

        // Obtener los estados traducidos
        $states = config('messages.states');

        // Pasar los datos a la vista
        return view('loads.show', [
            'machine' => $machine,
            'loads' => $loads,
            'totalQuantity' => $totalQuantity, // Total calculado correctamente
            'totalPartial' => $totalPartial, // Suma de PARTIAL
            'totalIrrecoverable' => $totalIrrecoverable, // Suma de Irrecuperables
            'states' => $states,
            'user' => $user,
            'userTecnicos' => $userTecnicos
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit');
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Convertir 'Irrecoverable' a booleano
        $request->merge([
            'Irrecoverable' => filter_var($request->input('Irrecoverable'), FILTER_VALIDATE_BOOLEAN),
        ]);

        // Definir las reglas de validación básicas
        $rules = [
            'Number' => 'required|integer',
            'Quantity' => 'required|numeric',
            'Partial_quantity' => 'nullable|numeric',
            'Irrecoverable' => 'required|boolean',
            'State' => 'required|string',
            'created_at' => 'nullable|date',
            'Date_recovered' => 'nullable|date',
            'closed_for' => 'nullable|integer', // Puede ser nulo inicialmente
        ];

        // Añadir la regla para 'closed_for' si 'Irrecoverable' es verdadero
        if ($request->input('Irrecoverable')) {
            $rules['closed_for'] = 'required|integer'; // Requerir 'closed_for' si 'Irrecoverable' es true
        }

        // Validar los datos
        $validatedData = $request->validate($rules);

        // Buscar la carga
        $load = Load::find($id);
        if (!$load) {
            return redirect()->back()->with('error', 'Carga no encontrada.');
        }

        // Guardar el estado actual antes de actualizar
        $previousState = $load->State;

        // Actualizar campos de la carga
        $load->Number = $validatedData['Number'];
        $load->Quantity = $validatedData['Quantity'];
        $load->Irrecoverable = $validatedData['Irrecoverable'];

        // Si el estado es 'RECOVERED', poner Partial_quantity a 0
        if ($validatedData['State'] === 'RECOVERED' && $previousState === 'PARTIAL') {
            $load->Partial_quantity = 0;
        } else {
            $load->Partial_quantity = $validatedData['Partial_quantity'] ?? $load->Partial_quantity;
        }

        // Actualizar la fecha de creación si se proporciona
        if (!empty($validatedData['created_at'])) {
            $load->created_at = \Carbon\Carbon::parse($validatedData['created_at']);
        }

        // Manejar los cambios según el estado y el valor de Irrecoverable
        if ($validatedData['Irrecoverable']) {
            // Si Irrecoverable es true
            $load->Closed_for = $validatedData['closed_for']; // Usar el valor validado
            $load->date_recovered = now();

            // Actualizar el estado en función de Partial_quantity
            if (!empty($validatedData['Partial_quantity'])) {
                $load->State = 'PARTIAL'; // Establecer el estado como PARTIAL
            } else {
                $load->State = 'CLOSED'; // Establecer el estado como CLOSED
            }
        } else {
            // Si Irrecoverable es false
            switch ($validatedData['State']) {
                case 'RECOVERED':
                    if ($load->State !== 'RECOVERED') {
                        $load->State = 'RECOVERED';
                        $load->Closed_for = auth()->id(); // Actualizar closed_for con el usuario logueado
                    }
                    $load->date_recovered = !empty($validatedData['Date_recovered'])
                        ? \Carbon\Carbon::parse($validatedData['Date_recovered'])
                        : $load->date_recovered;
                    break;

                case 'OPEN':
                case 'PAID':
                    if ($load->State !== $validatedData['State']) {
                        $load->State = $validatedData['State'];
                        // Restablecer `date_recovered` a null y mantener `closed_for`
                        $load->date_recovered = null;
                    }
                    break;

                case 'PARTIAL':
                    if ($load->State !== $validatedData['State']) {
                        $load->State = $validatedData['State'];
                        // Mantener `closed_for` y `date_recovered` sin cambios
                    }
                    break;
                case 'CLOSED':
                    if ($load->State !== $validatedData['State']) {
                        $load->State = $validatedData['State'];
                        // Mantener `closed_for` y `date_recovered` sin cambios
                    }
                    break;

                default:
                    if ($load->State !== $validatedData['State']) {
                        $load->State = $validatedData['State'];
                    }
                    break;
            }
        }

        // Guardar los cambios
        $load->save();

        return redirect()->back()->with('success', 'Carga actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la carga por ID
        $load = Load::find($id);

        if ($load) {
            // Obtener la máquina asociada
            $machine = Machine::find($load->machine_id);

            if ($machine) {
                // Eliminar la carga
                $load->delete();

                // Redirigir a la vista adecuada según los atributos de la máquina
                if ($machine->bar_id !== null) {
                    return redirect()->route('loads.showBar', [$machine->bar_id, $machine->id])
                        ->with('success', Lang::get('messages.load_deleted'));
                } elseif ($machine->local_id !== null) {
                    return redirect()->route('loads.showLocal', [$machine->local_id, $machine->id])
                        ->with('success', Lang::get('messages.load_deleted'));
                } else {
                    return redirect('/')->with('success', Lang::get('messages.load_deleted'));
                }
            } else {
                return redirect('/')->with('error', Lang::get('messages.machine_not_found'));
            }
        } else {
            return redirect('/')->with('error', Lang::get('messages.load_not_found'));
        }
    }
}
