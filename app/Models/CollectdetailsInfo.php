<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectdetailsInfo extends Model
{
    use HasFactory;

    protected $table =  'collectdetailsinfo';
    public $timestamps = true;

    public function local()
    {
        return $this->hasMany(Local::class, 'local_id', 'id');
    }
}
