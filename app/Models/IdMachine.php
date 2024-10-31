<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdMachine extends Model
{
    use HasFactory;

    protected $table =  'idmachines';

    protected $fillable = [
        'name',
        'id'
    ];




}
