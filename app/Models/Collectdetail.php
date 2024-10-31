<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Collectdetail extends Model
{
    protected $table = 'collectdetails';

    public $timestamps = true;
    use HasFactory;

    public function local()
    {
        return $this->belongsTo(Local::class,'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($collectdetails) {
            $collectdetails->last_modified_at_collectdetails = now(); // Actualizar el campo last_modified_at_tickets con la fecha y hora actuales
        });
    }

    // para traer los valores de las apuestas
    public static function apuestas($collectDetails)
    {
        return $collectDetails->where('Name', 'Apuestas');
    }

    // para traer los valores del principal de la money 'Disponible'
    public static function disponible($collectDetails)
    {
        return $collectDetails->where('Name', 'Principal');

    }

    // para traer los valores de las auxiliares
    public static function auxiliares($collectDetails)
    {
        return $collectDetails->whereNotIn('Name', ['Principal', 'Apuestas']);
    }

    // valores necesarios para operar con la tabla de COLLECTDETAILS
    public static function valoresParaCollectDetails50($collectDetails)
    {
        $bApuestas = intval($collectDetails->where('Name', 'Apuestas')->sum('Money3'));
        $bAuxiliares = intval($collectDetails->whereNotIn('Name', ['Principal', 'Apuestas'])->sum('Money3'));
        $principal = $collectDetails->where('Name', 'Principal')->first();

        $bc = $bApuestas + $bAuxiliares;
        $saldoInicial = intval($principal->Money3 - $bc);

        $porcientodel50 = intval($saldoInicial * 0.5);
        $principalMoney1 = intval($principal->Money1);

        $data =[
            'saldoInicial' => $saldoInicial,
            'x50saldoInicial' => $porcientodel50,
            'disponible' => $principalMoney1
        ];

        $aux = json_encode($data);
        $valoresCollectDetail50 = json_decode($aux);

        return $valoresCollectDetail50;
    }

    public static function disponibleAllMoneys($collectDetails){

        $data =  $collectDetails->where('Name', 'Principal')->first();

        $principal = [
            'id' => $data->id,
            'idMachine' => $data->idMachine,
            'Name' => $data->Name,
            'Money1' => $data->Money1,
            'Money2' => $data->Money2,
            'Money3' => $data->Money3,
            'CollectDetailType' => $data->CollectDetailType,
            'State' => $data->State,
        ];

        return json_encode($data);
    }

    public static function orden($collectDetails){

    }
}
