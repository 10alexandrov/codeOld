<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMachines extends Model
{
    protected $fillable = ['name'];
    use HasFactory;

    public function delegation()
    {
        return $this->belongsToMany(Delegation::class,'type_machines_delegations', 'type_machine_id', 'delegation_id');
    }

    public function locals()
    {
        return $this->belongsToMany(Local::class,'type_machines_local', 'type_machine_id', 'local_id');
    }
}
