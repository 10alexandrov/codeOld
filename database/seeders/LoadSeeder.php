<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Load;
use App\Models\Machine;
use App\Models\User;

class LoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los usuarios con el rol de "Tecnico"
        $tecnicos = User::role('Tecnico')->pluck('id');

        // Obtener todas las máquinas
        $machines = Machine::all();

        // Inicializar el contador de números únicos
        $uniqueNumber = 1;

        foreach ($machines as $machine) {
            // Verificar si la máquina está asociada a un local
            if ($machine->local_id !== null) {
                // Crear la carga inicial (Initial = true) solo para máquinas con local_id no nulo
                Load::create([
                    'Number' => $uniqueNumber++, // Número único para la carga
                    'Quantity' => 500, // Cantidad fija
                    'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                    'Closed_for' => null, // No asignar aún
                    'Partial_quantity' => 0, // Cantidad parcial
                    'Irrecoverable' => false, // Irrecoverable siempre false para cargas iniciales
                    'Initial' => true, // Carga inicial
                    'State' => 'OPEN', // Estado inicial
                    'date_recovered' => null, // Fecha de recibido (nulo para OPEN)
                    'updated_at' => now(), // Fecha de actualización
                    'machine_id' => $machine->id,
                ]);
            }

            // Crear cargas para todas las máquinas (tanto locales como bares)

            // Carga con estado OPEN (Initial = false)
            Load::create([
                'Number' => $uniqueNumber++, // Número único para la carga
                'Quantity' => 520, // Cantidad fija
                'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Closed_for' => null, // No asignar aún
                'Partial_quantity' => 0, // Cantidad parcial
                'Irrecoverable' => false, // Irrecoverable solo true si Partial_quantity es 300
                'Initial' => false, // Carga adicional
                'State' => 'OPEN', // Estado OPEN
                'date_recovered' => null, // Fecha de recibido (nulo para OPEN)
                'updated_at' => now(), // Fecha de actualización
                'machine_id' => $machine->id,
            ]);

            // Carga con estado PAID (Initial = false)
            Load::create([
                'Number' => $uniqueNumber++, // Número único para la carga
                'Quantity' => 540, // Cantidad fija
                'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Closed_for' => null, // No asignar aún
                'Partial_quantity' => 0, // Cantidad parcial
                'Irrecoverable' => false, // Irrecoverable solo true si Partial_quantity es 300
                'Initial' => false, // Carga adicional
                'State' => 'PAID', // Estado PAID
                'date_recovered' => null, // Fecha de recibido (nulo para PAID)
                'updated_at' => now(), // Fecha de actualización
                'machine_id' => $machine->id,
            ]);

            // Carga con estado RECEIVED (Initial = false)
            $partialQuantity = rand(1, 100) <= 5 ? rand(1, 540) : 0; // Probabilidad de cantidad parcial inferior a la cantidad total
            $receivedDate = now(); // Fecha cuando el estado cambia a RECEIVED
            Load::create([
                'Number' => $uniqueNumber++, // Número único para la carga
                'Quantity' => 540, // Cantidad fija
                'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Closed_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Partial_quantity' => $partialQuantity, // Cantidad parcial
                'Irrecoverable' => $partialQuantity > 0, // Irrecoverable verdadero si Partial_quantity es mayor que 0
                'Initial' => false, // Carga adicional
                'State' => 'RECOVERED', // Estado RECEIVED
                'date_recovered' => $receivedDate, // Fecha de recibido
                'updated_at' => $receivedDate, // Fecha de actualización
                'machine_id' => $machine->id,
            ]);

            // Carga con estado PARTIAL (Initial = false)
            $partialQuantity = rand(1, 100) <= 5 ? rand(1, 560) : rand(1, 559); // Probabilidad de cantidad parcial menor a la cantidad total
            Load::create([
                'Number' => $uniqueNumber++, // Número único para la carga
                'Quantity' => 560, // Cantidad fija
                'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Closed_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Partial_quantity' => $partialQuantity, // Cantidad parcial
                'Irrecoverable' => $partialQuantity > 0, // Irrecoverable verdadero si Partial_quantity es mayor que 0
                'Initial' => false, // Carga adicional
                'State' => 'PARTIAL', // Estado PARTIAL
                'date_recovered' => $receivedDate, // Mantener la fecha de RECEIVED
                'updated_at' => now(), // Fecha de actualización
                'machine_id' => $machine->id,
            ]);

            // Carga con estado CLOSED (Initial = false)
            $partialQuantity = rand(1, 100) <= 5 ? rand(1, 560) : 0; // Probabilidad de cantidad parcial
            Load::create([
                'Number' => $uniqueNumber++, // Número único para la carga
                'Quantity' => 560, // Cantidad fija
                'Created_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Closed_for' => $tecnicos->random(), // Asignar un técnico aleatorio
                'Partial_quantity' => $partialQuantity, // Cantidad parcial
                'Irrecoverable' => $partialQuantity > 0, // Irrecoverable verdadero si Partial_quantity es mayor que 0
                'Initial' => false, // Carga adicional
                'State' => 'CLOSED', // Estado CLOSED
                'date_recovered' => $receivedDate, // Mantener la fecha de RECEIVED
                'updated_at' => now(), // Fecha de actualización
                'machine_id' => $machine->id,
            ]);
        }
    }
}
