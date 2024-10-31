<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class,'delegation_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'delegations_users');
    }

    public function typeMachines()
    {
        return $this->belongsToMany(TypeMachines::class, 'type_machines_delegations','delegation_id','type_machine_id');
    }

    public function usersTicketServer()
    {
        return $this->belongsToMany(UserTicketServer::class, 'usersmc_delegations','delegation_id','users_ticket_server_id');
    }

    public function lastUserMcDate()
    {
        return $this->hasOne(lastUserMcDate::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
