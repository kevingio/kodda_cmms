<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_id',
        'qty',
        'reason',
        'resource_id',
        'mode',
        'type'
    ];

    /**
    * Inventory Type
    * 1 -> work order
    * 2 -> maintenance report
    * 3 -> storeman
    */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
    * Relation to work order
    */
    public function work_order()
    {
        return $this->belongsTo('App\Models\WorkOrder', 'resource_id', 'id')
            ->join('inventory_reports', 'inventory_reports.resource_id', 'users.id')
            ->where('inventory_reports.type', 1);
    }

    /**
    * Relation to maintenance report
    */
    public function mt_report()
    {
        return $this->belongsTo('App\Models\MaintenanceReport', 'resource_id', 'id')
            ->join('inventory_reports', 'inventory_reports.resource_id', 'users.id')
            ->where('inventory_reports.type', 2);
    }

    /**
    * Relation to user
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'resource_id', 'id')
            ->join('inventory_reports', 'inventory_reports.resource_id', 'users.id')
            ->where('inventory_reports.type', 3);
    }

    /**
    * Relation to inventory
    */
    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory');
    }

    /**
    * Make report
    * @param App\Models\Inventory $inventory
    * @param integer $type
    */
    public function makeReport($inventory, $type, $resource_id)
    {
        return Self::create([
            'inventory_id' => $inventory->id,
            'mode' => 'out',
            'qty' => $inventory->qty,
            'type' => $type,
            'resource_id' => $resource_id
        ]);
    }
}
