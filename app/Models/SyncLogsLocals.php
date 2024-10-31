<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SyncLogsLocals extends Model
{
    use HasFactory;

    protected $fillable = [
        'local_id',
        'status',
        'message',
    ];

    protected $table =  'sync_logs_locals';
    public $timestamps = true;

    public function local()
    {
        return $this->hasMany(Local::class, 'local_id', 'id');
    }

    public static function conectionMoneys($idDelegation)
    {

        // Obtener la delegación con sus zonas y locales
        $delegation = Delegation::with(['zones.locals.syncLogsLocals'])
            ->find($idDelegation);

        // Verificar si la delegación fue encontrada
        if (!$delegation) {
            return response()->json(['error' => 'Los datos de la delegación no funcionan'], 404);
        }

        // Array para almacenar el estado de conexión de cada local
        $connectionStatus = [];

        // Iterar sobre las zonas de la delegación
        foreach ($delegation->zones as $zone) {
            // Iterar sobre los locales de la zona
            foreach ($zone->locals as $local) {
                // Verificar si existen registros de SyncLogsLocals para este local
                if ($local->syncLogsLocals->isNotEmpty()) {
                    // Obtener los datos de conexión de cada registro de SyncLogsLocals
                    foreach ($local->syncLogsLocals as $syncLog) {
                        $connectionStatus[] = $syncLog;
                    }
                }
            }
        }

        //dd($connectionStatus);

        // Devolver el array con el estado de conexión de cada local
        return $connectionStatus;
    }

    //Log::info('Estado de conexión de los locales:', $connectionStatus);

}
