<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Energy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lwbp',
        'wbp',
        'pdam',
        'deep_well',
        'lpg',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];
}
