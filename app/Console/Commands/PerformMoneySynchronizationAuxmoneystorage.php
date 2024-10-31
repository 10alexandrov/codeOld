<?php

namespace App\Console\Commands;

use App\Models\Local;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PerformMoneySynchronizationAuxmoneystorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prometeo:sync-money-auxmoneystorage {local_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script que sincroniza los datos de las máquinas de cambio de los locales para la tabla AUXMONEYSTORAGE';

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
            DB::purge($connectionName);
            DB::connection($connectionName)->getPdo();

            $auxmoneystorage = DB::connection($connectionName)->table('auxmoneystorage')->get();

            foreach ($auxmoneystorage as $item) {
                $existingRecord = DB::table('auxmoneystorage')
                    ->where('local_id', $local->id)
                    ->where('Machine', $item->Machine)
                    ->where('TypeIsAux', $item->TypeIsAux)
                    ->where('AuxName', $item->AuxName)
                    ->first();

                if (!$existingRecord) {
                    DB::table('auxmoneystorage')->insert([
                        'local_id' => $local->id,
                        'Machine' => $item->Machine,
                        'TypeIsAux' => $item->TypeIsAux,
                        'AuxName' => $item->AuxName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Log::info('Registro insertado:', ['local_id' => $local->id, 'Machine' => $item->Machine]);
                }
            }
            DB::commit();
            echo "Datos sincronizados correctamente.";
        } catch (Exception $e) {
            DB::rollBack();
            echo "Error al insertar los datos: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }
}
