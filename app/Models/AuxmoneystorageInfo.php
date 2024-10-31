<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuxmoneystorageInfo extends Model
{
    use HasFactory;

    protected $table =  'auxmoneystorageinfo';
    public $timestamps = true;

    public function local()
    {
        return $this->hasMany(Local::class, 'local_id', 'id');
    }
}
