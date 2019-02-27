<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\Datatables\Datatables;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'contact',
        'avatar',
        'department_id',
        'job_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token',
    ];

    /**
     * Relation to department
     *
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department')->withTrashed();
    }

    /**
     * Relation to job
     *
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job')->withTrashed();
    }

    /**
     * Relation to role
     *
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Relation to users
     *
     */
    public function work_orders()
    {
        return $this->belongsToMany('App\Models\WorkOrder', 'work_order_users')->withTrashed();
    }

    /**
     * Get users except logged in user by role id
     *
     * @param int $role_id
     * @return array
     */
    public function getUserByRole($role_id)
    {
        return $this->where('role_id', $role_id)->where('id', '!=', auth()->user()->id)->get();
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $results = $this->with(['department', 'job', 'role'])->where('role_id', '!=', 1)->where('id', '!=', auth()->id())->get();
        return Datatables::of($results)
            ->editColumn('name', function ($data) {
                $image = asset('assets/images/default-photo.png');
                if(!empty($data->avatar)) {
                    $image = Storage::url($data->avatar);
                }
                $html = '<img src="'.$image.'" alt="user-image" class="thumb-md rounded-circle mr-2"/>';
                return $html . $data->name;
            })
            ->editColumn('department', function ($data) {
                return $data->department->name;
            })
            ->editColumn('job', function ($data) {
                return $data->job->title;
            })
            ->editColumn('role', function ($data) {
                return $data->role->name;
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-primary edit waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger delete waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-info info waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="View Avatar">
                    <i class="mdi mdi-information"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-warning reset waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Reset Password">
                    <i class="mdi mdi-lock"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['name','action'])
            ->make(true);
    }
}
