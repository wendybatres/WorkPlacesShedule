<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workplacesshedule extends Model
{
    use HasFactory;

    protected $table = 'workplacesshedule'; // Nombre de la tabla

    protected $fillable = [
        'userworkplacessheduleid',
        'userid',
        'shedule',
        'isadminrequest',
        'isactive',
        'created',
        'creator',
        'modified',
        'modifier'
    ];
}
