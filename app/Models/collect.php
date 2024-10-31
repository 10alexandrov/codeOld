<?php

namespace App\Models;

use App\Models\Local;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Collect extends Model
{
    use HasFactory;


    protected $table =  'collects';
    public $timestamps = true;

    public function local()
    {
        return $this->belongsTo(Local::class,'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($collects) {
            $collects->last_modified_at_collects = now(); // Actualizar el campo last_modified_at_tickets con la fecha y hora actuales
        });
    }

    // Calculos dinero Activo
    public static function dineroActivo($collects)
    {
        return
            self::totalRecicladores($collects) +
            self::totalPagadores($collects) +
            self::totalMultimoneda($collects);
    }

    public static function totalRecicladores($collects)
    {
        return $collects->whereIn('LocationType', ['Cassette 1', 'Cassette 2', 'Cassette 3', 'Cassette 4', 'Cassette 5'])->sum('Amount');
    }

    public static function totalPagadores($collects)
    {
        return $collects->where('LocationType', 'Hopper 2')->sum('Amount');
    }

    public static function totalMultimoneda($collects)
    {
        return $collects->where('LocationType', 'MultiCoin')->sum('Amount');
    }

    // Calculos dinero No Activo
    public static function dineroNoActivo($collects)
    {
        return
            self::totalApiladores($collects) +
            self::totalRechazoDispensador($collects) +
            self::totalCajones($collects) +
            self::totalCajonesVirtuales($collects);
    }

    public static function totalApiladores($collects)
    {
        return $collects->where('LocationType', 'Stacker')->sum('Amount');
    }

    public static function totalRechazoDispensador($collects)
    {
        return $collects->where('LocationType', 'Puloon Stacker')->sum('Amount');
    }

    public static function totalCajones($collects)
    {
        return $collects->where('LocationType', 'Cashbox')->sum('Amount');
    }

    public static function totalCajonesVirtuales($collects)
    {
        //return $collects->where('LocationType', 'Cashbox Virtual')->sum('Amount');
        return 0;
    }

    public static function arqueoTotal($collects)
    {

        return self::dineroActivo($collects) +
            self::dineroNoActivo($collects);
    }

    public static function colocarCampos($collects)
    {
        // json para colocar como queremos que salga en la vista y ponerlo en castellano
        $order = [
            "Hopper 2" => "Hopper 1€",
            "MultiCoin" => "Multimoneda",
            "Puloon Stacker" => "Rechazo",
            "Cassette 1" => "Reciclador 1",
            "Cassette 2" => "Reciclador 2",
            "Cassette 3" => "Reciclador 3",
            "Cassette 4" => "Reciclador 4",
            "Cassette 5" => "Reciclador 5",
            "Stacker" => "Stacker",
            "Cashbox" => "Cajón",
            "Manual" => 'Manual'
        ];

        // Función para ordenar la colección
        $collects = $collects->sortBy(function ($item) use ($order) {
            return array_search($item->LocationType, array_keys($order));
        });

        // Mapear los nombres de los campos
        $collects->transform(function ($item) use ($order) {
            $item->LocationType = $order[$item->LocationType];
            return $item;
        });

        // Convertir la colección ordenada a un array y luego a JSON
        $orderedCollection = $collects->values()->toArray();
        $orderedCollectionJson = json_encode($orderedCollection);

        return $orderedCollectionJson;
    }

    public static function allMoneys($idDelegation)
    {
        //coger todos los datos de collects, collectsdetails y tickets que dependas de delegacion para sacar los valores inferiores a la condicion
        $delegation = Delegation::with(['zones.locals.collects', 'zones.locals.collectdetails', 'zones.locals.tickets'])->find($idDelegation);

        if (!$delegation) {

            return response()->json(['error' => 'Delegation data not found'], 404);
        }

        return $delegation;
    }
}
