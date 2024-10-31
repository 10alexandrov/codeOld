<?php

namespace App\Http\Controllers;

use App\Jobs\MoneySynchronizationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function syncMachineBlue($id){
        Artisan::call('prometeo:perform-prometeo-sync-blue-users-ticket ' . $id);
        Artisan::call('prometeo:sync-money-type-machines-blue ' . $id);
        return redirect()->back();
    }

    public function actualizarLocal($id){
/*         MoneySynchronizationJob::dispatch($id); */
        Artisan::call('prometeo:sync-money '. $id);
        Artisan::call('prometeo:sync-money-synchronization24h '. $id);
        Artisan::call('prometeo:sync-money-auxmoneystorage '. $id);
        Artisan::call('prometeo:sync-money-config '. $id);
        return redirect()->back();
    }
}
