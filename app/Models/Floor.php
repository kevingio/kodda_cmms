<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Datatables\Datatables;

class Floor extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

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
        'description'
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
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $datas = Self::all();
        return Datatables::of($datas)
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit-floor waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger delete-floor waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
