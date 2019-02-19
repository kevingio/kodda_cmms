<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Datatables\Datatables;

class MaintenanceTask extends Model
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
        'task', 'equipment_model_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * Relation to inventory model
     *
     */
    public function equipment_model()
    {
        return $this->belongsTo('App\Models\EquipmentModel')->withTrashed();
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $datas = Self::with('equipment_model')->orderBy('created_at', 'desc')->get();
        return Datatables::of($datas)
            ->editColumn('model', function ($data) {
                return $data->equipment_model->name;
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit-maintenance waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger delete-maintenance waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
