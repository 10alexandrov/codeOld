<?php

namespace App\Models;

use App\Models\Money\CollectDetails;
use Database\Seeders\UsersTicketServerSeedeer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_zone',
        'ip_address',
        'port',
        'idMachine'
    ];

    public function zone()
    {
       return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function collects()
    {
        return $this->hasMany(Collect::class, 'local_id');
    }

    public function collectDetails()
    {
        return $this->hasMany(CollectDetail::class, 'local_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'idMachine', 'idMachines');
    }

    public function syncLogsLocals()
    {
        return $this->hasMany(SyncLogsLocals::class, 'local_id');
    }

    public function latest_Updates()
    {
        return $this->hasMany(Latest_Updates::class, 'local_id');
    }

    public function accounting()
    {
        return $this->hasMany(Accounting::class, 'local_id');
    }

    public function accountinginfo()
    {
        return $this->hasMany(AccountingInfo::class, 'local_id');
    }

    public function auxmoneystorage()
    {
        return $this->hasMany(Auxmoneystorage::class, 'local_id');
    }

    public function auxmoneystorageinfo()
    {
        return $this->hasMany(AuxmoneystorageInfo::class, 'local_id');
    }

    public function betmoneystorage()
    {
        return $this->hasMany(Betmoneystorage::class, 'local_id');
    }

    public function betmoneystorageinfo()
    {
        return $this->hasMany(BetmoneystorageInfo::class, 'local_id');
    }

    public function collectinfo()
    {
        return $this->hasMany(CollectInfo::class, 'local_id');
    }

    public function collectdetailsinfo()
    {
        return $this->hasMany(CollectdetailsInfo::class, 'local_id');
    }

    public function config()
    {
        return $this->hasMany(ConfigMC::class, 'local_id');
    }

    public function hcmoneystorage()
    {
        return $this->hasMany(Hcmoneystorage::class, 'local_id');
    }

    public function hcmoneystorageinfo()
    {
        return $this->hasMany(HcmoneystorageInfo::class, 'local_id');
    }

    public function hiddentickets()
    {
        return $this->hasMany(Hiddentickets::class, 'local_id');
    }

    public function logs()
    {
        return $this->hasMany(Logs::class, 'local_id');
    }

    public function players()
    {
        return $this->hasMany(Players::class, 'local_id');
    }

    public function sessionsTickectServer()
    {
        return $this->hasMany(SessionsTicketServer::class, 'local_id');
    }

    public function usersTicketServer()
    {
        return $this->belongsToMany(UserTicketServer::class, 'usersmc_locals','local_id','users_ticket_server_id');
    }

    public function auxiliares()
    {
        return $this->hasMany(Auxiliar::class, 'local_id');
    }

    public function type_machines()
    {
        return $this->belongsToMany(TypeMachines::class, 'type_machines_local', 'local_id', 'type_machine_id');
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

}


