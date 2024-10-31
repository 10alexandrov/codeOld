<?php

namespace App\Console\Commands;

use App\Models\Local;
use App\Models\TypeMachines;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformMoneySynchronizationTypeMachines_DESUSE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prometeo:sync-money-type-machines {local_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script que sincroniza los typos de maquinas que hay en una delegacion';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $local_id = $this->argument('local_id');

        if (!$local_id) {
            $locals = Local::all();

            foreach ($locals as $local) {
                $this->connectToLocal($local);
            }
        }else{

            $local = Local::find($local_id);
            $this->connectToLocal($local);
        }
    }

    protected function connectToLocal(Local $local): void
    {
        $connectionName = 'mariadb';
        $datosConexion = json_decode($local->dbconection);
        $conexionCero = $datosConexion[0];

        // Configurar la conexión a la base de datos
        Config::set("database.connections.$connectionName", [
            'driver' => 'mysql',
            'host' => $conexionCero->ip,
            'port' => $conexionCero->port,
            'database' => $conexionCero->database,
            'username' => $conexionCero->username,
            'password' => $conexionCero->password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);

        try {
            // Purgar la conexión y obtener el PDO
            DB::purge($connectionName);
            DB::connection($connectionName)->getPdo();

            // Consulta para traer todos los tipos de maquinas tragaperras
            $typeMachines = DB::connection($connectionName)->table('tickets')->distinct()->get();

            DB::beginTransaction();

            // INSERT OR UPDATE para la tabla type_machines
            foreach ($typeMachines as $machine) {
                $typeMachine = TypeMachines::firstOrCreate(
                    ['name' => $machine->Type],
                    ['delegation_id' => $local->zone->delegation_id, 'created_at' => now(), 'updated_at' => now()]
                );

                $local->type_machines()->syncWithoutDetaching([$typeMachine->id]);
            }

            DB::commit();
            echo "Datos sincronizados correctamente.";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Error al insertar los datos: " . $e->getMessage();
        }
    }
}
