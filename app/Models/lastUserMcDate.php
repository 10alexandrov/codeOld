<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lastUserMcDate extends Model
{
    use HasFactory;
    protected $table =  'last_usermc_date';
    public $timestamps = false;

    protected $fillable = [
        'delegation_id',
        'lastDate',
    ];

    public function delegation()
    {
        return $this->belongsTo(Delegation::class);
    }
}
