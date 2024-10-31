<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Local;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\TypeMachines;
use App\Models\ConfigMC;
use Illuminate\Support\Facades\Log;


class PerformPrometeoSyncBlueTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prometeo:sync-money-type-machines-blue {local_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script que sincroniza los typos de tickets que hay en local para enviarlo al programa azul';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $local_id = $this->argument('local_id');

        if (!$local_id) {
            $this->error("Necesitamos el local al que quiere conectar");
            return 0;
        }

        $local = Local::find($local_id);
        if (!$local) {
            $this->error("Local no encontrado");
            return 0;
        }

        $connectionName = 'mariadb';
        $datosConexion = json_decode($local->dbconection);

        for ($i = 1; $i < count($datosConexion); $i++) {
            $conexionCero = $datosConexion[$i];

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

            // Conectar a la base de datos del ticket server
            DB::purge($connectionName);
            DB::reconnect($connectionName);

            try {
                DB::connection($connectionName)->beginTransaction();

                $tipos = TypeMachines::all();
                $config = ConfigMC::where('local_id', $local->id)->first();


                foreach ($tipos as $tipo) {
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
                        'Type' => $tipo->name,
                        'TypeIsBets' => 0,
                        'TypeIsAux' => 1,
                        'HideOnTC' => 0,
                        'Used' => 0,
                        'TITOExpirationType' => 0,
                    ];

                    DB::connection($connectionName)->table('tickets')->insert($insertData);
                    Log::info('Ticket insertado: ' . json_encode($insertData));
                }
                $this->info("Inserción de tickets completada.");
            } catch (\Exception $e) {
                Log::error('Error al insertar los tickets: ' . $e->getMessage());
                $this->error('Error al insertar los tickets: ' . $e->getMessage());
            }
        }
    }
}
