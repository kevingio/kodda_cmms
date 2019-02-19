<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaintenanceReportUsers extends Pivot
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'maintenance_report_id',
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
