<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class WorkReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'activity', 'work_date'
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
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $results = Self::with('user.job.department')->orderBy('created_at', 'desc')->get();
        return Datatables::of($results)
            ->editColumn('name', function ($data) {
                return $data->user->name;
            })
            ->editColumn('department', function ($data) {
                return $data->user->job->department->name;
            })
            ->editColumn('job', function ($data) {
                return $data->user->job->title;
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-info info waves-effect waves-light" data-id="'.encrypt($data->id).'">
                    <i class="mdi mdi-information"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
