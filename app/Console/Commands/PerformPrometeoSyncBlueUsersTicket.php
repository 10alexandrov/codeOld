<?php

namespace App\Console\Commands;

use App\Models\Local;
use App\Models\TypeMachines;
use App\Models\ConfigMC;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PerformPrometeoSyncBlueUsersTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prometeo:perform-prometeo-sync-blue-users-ticket {local_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script que sincroniza los usuarios de prometeo "ticket server" con el programa azul de la maquina de cambio';

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

        if (is_array($local) || $local instanceof \Illuminate\Support\Collection) {
            $this->error("Se ha encontrado más de un local, se esperaba solo uno.");
            return 0;
        }

        if (empty($local->dbconection)) {
            $this->error("La propiedad dbconection no existe o está vacía en el local encontrado.");
            return 0;
        }

        $users_ticket_server = $local->usersTicketServer;

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

                DB::connection($connectionName)
                    ->table('users')
                    ->where('IsRoot', '!=', 1)
                    ->delete();

                // Manejar usuarios de ticket server
                foreach ($users_ticket_server as $user) {
                    try {
                        $decryptedPassword = Crypt::decrypt($user->Password);

                        if($user->PID != ''){
                            $decryptedPID = Crypt::decrypt($user->PID);
                        }else{
                            $decryptedPID = '';
                        }

                        $existingRecord = DB::connection($connectionName)->table('users')
                            ->where('User', $user->User)
                            ->first();

                        if ($existingRecord) {
                            DB::connection($connectionName)->table('users')
                                ->where('User', $user->User)
                                ->update([
                                    'Password' => $decryptedPassword,
                                    'Rights' => $user->Rights,
                                    'IsRoot' => $user->IsRoot,
                                    'RightsCanBeModified' => $user->RightsCanBeModified,
                                    'CurrentBalance' => $user->CurrentBalance,
                                    'ReloadBalance' => $user->ReloadBalance,
                                    'ReloadEveryXMinutes' => $user->ReloadEveryXMinutes,
                                    'LastReloadDate' => $this->convertDateTime($user->LastReloadDate),
                                    'ResetBalance' => $user->ResetBalance,
                                    'ResetAtHour' => $user->ResetAtHour,
                                    'LastResetDate' => $this->convertDateTime($user->LastResetDate),
                                    'MaxBalance' => $user->MaxBalance,
                                    'TicketTypesAllowed' => $user->TicketTypesAllowed,
                                    'PID' => $decryptedPID,
                                    'NickName' => $user->NickName,
                                    'Avatar' => $user->Avatar,
                                    'PIN' => $user->PIN,
                                    'SessionType' => $user->SessionType,
                                    'AdditionalOptionsAllowed' => $user->AdditionalOptionsAllowed,
                                ]);

                            Log::info('Registro actualizado en users: User=' . $user->User);
                        } else {
                            $user_id = DB::connection($connectionName)->table('users')->insertGetId([
                                'User' => $user->User,
                                'Password' => $decryptedPassword,
                                'Rights' => $user->Rights,
                                'IsRoot' => $user->IsRoot,
                                'RightsCanBeModified' => $user->RightsCanBeModified,
                                'CurrentBalance' => $user->CurrentBalance,
                                'ReloadBalance' => $user->ReloadBalance,
                                'ReloadEveryXMinutes' => $user->ReloadEveryXMinutes,
                                'LastReloadDate' => $this->convertDateTime($user->LastReloadDate),
                                'ResetBalance' => $user->ResetBalance,
                                'ResetAtHour' => $user->ResetAtHour,
                                'LastResetDate' => $this->convertDateTime($user->LastResetDate),
                                'MaxBalance' => $user->MaxBalance,
                                'TicketTypesAllowed' => $user->TicketTypesAllowed,
                                'PID' => $decryptedPID,
                                'NickName' => $user->NickName,
                                'Avatar' => $user->Avatar,
                                'PIN' => $user->PIN,
                                'SessionType' => $user->SessionType,
                                'AdditionalOptionsAllowed' => $user->AdditionalOptionsAllowed,
                            ]);

                            Log::info('Nuevo registro insertado en users: User=' . $user->User);
                        }

                        DB::connection($connectionName)->commit();
                    } catch (\Exception $e) {
                        DB::connection($connectionName)->rollBack();
                        Log::error('Error sincronizando users para User: ' . $user->User . ' - ' . $e->getMessage());
                        $this->error('Error sincronizando users para User: ' . $user->User . ' - ' . $e->getMessage());
                        continue;
                    }
                }

            } catch (\Exception $e) {
                Log::error('Error al borrar los usuarios: ' . $e->getMessage());
            }
        }

        $this->info("Sincronización completada.");
    }

    /**
     * Convert date time to proper format
     */
    protected function convertDateTime($datetime)
    {
        if ($datetime == '0001-01-01 00:00:00') {
            return '0000-00-00 00:00:00';
        }
        return $datetime;
    }
}
