<?php

use App\Models\Local;
use App\Models\lastUserMcDate;

use Illuminate\Support\Facades\DB;


function Generate18Number($NumberOfDigits)
{
    $number = "";
    for ($i = 0; $i < $NumberOfDigits; $i++) {
        $num = mt_rand() % 10;
        $number .= $num;
    }

    return $number;
}

function GenerateNewNumberFormat($NumberOfDigits)
{
    $number = "";
    for ($i = 0; $i < $NumberOfDigits - 8; $i++) {
        $num = mt_rand() % 10;
        $number .= $num;
    }

    return "00000000" . $number;
}

function nuevaConexion($local)
{
    $localDate = Local::find($local);
    $connectionName = 'mariadb';

    // Decodificar el JSON de la conexión y obtener la primera conexión (índice 0)
    $datosConexion = json_decode($localDate->dbconection);
    $conexionCero = $datosConexion[0];  // Asegúrate de que el JSON sea un array y accede al primer elemento

    // Modificar la configuración de la conexión de base de datos
    config([
        'database.connections.' . $connectionName . '.host' => $conexionCero->ip,
        'database.connections.' . $connectionName . '.port' => $conexionCero->port,
        'database.connections.' . $connectionName . '.database' => $conexionCero->database,
        'database.connections.' . $connectionName . '.username' => $conexionCero->username,
        'database.connections.' . $connectionName . '.password' => $conexionCero->password,
    ]);

    // Limpiar la conexión para que se apliquen los nuevos valores
    DB::purge($connectionName);

    return $connectionName;
}

/*OBTER IP */
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function lastUsermcUpdate($delegation_id)
{
    if ($fecha = lastUserMcDate::where('delegation_id', $delegation_id)->first()) {
        // Si existe el registro, actualiza la fecha
        $fecha->update([
            'lastDate' => now()
        ]);
    } else {
        // Si no existe el registro, crea uno nuevo
        $newFecha = new lastUserMcDate();
        $newFecha->delegation_id = $delegation_id;
        $newFecha->lastDate = now();
        $newFecha->save();
    }
}


function translateState($state)
{
    switch ($state) {
        case 'OPEN':
            return 'ABIERTO';
        case 'PAID':
            return 'PAGADO';
        case 'RECOVERED':
            return 'RECUPERADO';
        case 'PARTIAL':
            return 'PARCIAL';
        case 'CLOSED':
            return 'CERRADO';
        default:
            return $state;
    }
}
