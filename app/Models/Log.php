<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'user_type',
        'action',
        'timestamp',
    ];

    public function user()
    {
        return $this->morphTo();
    }
}
