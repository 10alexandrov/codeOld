<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'year', 'serie', 'local_id', 'bar_id', 'alias', 'identificador'
    ];

    /**
     * Relación con el modelo Local.
     */
    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    /**
     * Relación con el modelo Bar.
     */
    public function bar()
    {
        return $this->belongsTo(Bar::class);
    }

    public function delegation()
    {
        return $this->belongsTo(Delegation::class);
    }

    public function loads()
    {
        return $this->hasMany(Load::class);
    }

    public function auxiliars()
    {
        return $this->hasMany(Auxiliar::class);
    }

}
