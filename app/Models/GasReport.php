<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class GasReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gas',
        'gas_comsumption',
        'gas_price',
        'gas_month_to_date',
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
    public function datatable($month, $year)
    {
        $results = Self::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        return Datatables::of($results)
            ->editColumn('day', function ($data) {
                return date('d', strtotime($data->created_at));
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-id="' . encrypt($data->id) . '" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
