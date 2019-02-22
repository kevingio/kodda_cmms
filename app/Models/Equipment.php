<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Datatables\Datatables;

class Equipment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_model_id',
        'manufacturer',
        'description',
        'serial_number',
        'location_id',
        'maintenance_period',
        'contact',
        'image'
    ];

    /**
     * Relation to inventory model
     *
     */
    public function model()
    {
        return $this->belongsTo('App\Models\EquipmentModel', 'equipment_model_id', 'id');
    }

    /**
     * Relation to location
     *
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $results = $this->with(['model', 'location.floor'])->get();
        return Datatables::of($results)
            ->editColumn('model', function ($data) {
                return $data->model->name;
            })
            ->editColumn('location', function ($data) {
                return $data->location->area . ' - ' . $data->location->floor->description;
            })
            ->editColumn('description', function ($data) {
                return $data->description == '' ? '-' : $data->description;
            })
            ->editColumn('maintenance_period', function ($data) {
                return $data->maintenance_period . ($data->maintenance_period > 1 ? ' months' : ' month');
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger delete waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Get Maintenace Data
     * @return array
     */
    public function maintenance()
    {
        $results = $this->with(['model', 'location.floor'])->get();
        $events = [];
        foreach ($results as $data) {
            $start_date = date('Y-m-d', strtotime('+' . $data->maintenance_period . ' month', strtotime($data->created_at)));
            $events[] = [
                'id' => $data->id,
                'title' => $data->model->name,
                'start' => $start_date,
                'className' => 'bg-primary',
                'repeat' => $data->maintenance_period,
            ];
        }
        return $events;
    }
}
