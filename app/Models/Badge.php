<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = [
        'type',
        'title',
        'condition_from',
        'condition_to',
        'description',
        'image'
    ];
}
