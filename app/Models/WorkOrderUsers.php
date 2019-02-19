<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkOrderUsers extends Pivot
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'work_order_id',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];
}
