<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cas extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'command',
        'execution_time',
        'error_occurred'
    ];
}
