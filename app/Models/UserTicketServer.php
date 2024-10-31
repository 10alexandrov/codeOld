<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTicketServer extends Model
{
    use HasFactory;

    protected $table =  'users_ticket_server';
    public $timestamps = false;

    protected $fillable = [
        'User', 'Name', 'Password', 'Rights', 'IsRoot', 'RightsCanBeModified',
        'CurrentBalance', 'ReloadBalance', 'ReloadEveryXMinutes', 'LastReloadDate',
        'ResetBalance', 'ResetAtHour', 'LastResetDate', 'MaxBalance',
        'TicketTypesAllowed', 'PID', 'NickName', 'Avatar', 'PIN', 'SessionType',
        'AdditionalOptionsAllowed', 'rol'
    ];

    public function locals()
    {
        return $this->belongsToMany(Local::class, 'usersmc_locals','users_ticket_server_id','local_id');
    }

    public function delegations()
    {
        return $this->belongsToMany(Delegation::class, 'usersmc_delegations','users_ticket_server_id','delegation_id');
    }

}
