<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class PoolLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cl',
        'ph',
        'remark',
        'method',
        'compound',
        'value',
        'user_id',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'user_id'
    ];

    /**
     * Relation to user
     *
     */
    public function done_by()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Combine date and time
     *
     * @param array $data
     */
    public function preprocessInput($data)
    {
        $data['user_id'] = auth()->id();
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($data['date'] . ' ' . $data['time']));
        return $data;
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $datas = Self::with('done_by')->latest()->get();
        return Datatables::of($datas)
            ->editColumn('date', function ($data) {
                return date('d M Y', strtotime($data->created_at));
            })
            ->editColumn('chemical', function ($data) {
                $unit = '';
                switch ($data->compound) {
                    case 'neo-chlorine 90':
                    case 'china-chlorine':
                        $unit = 'kg';
                        break;

                    default:
                        $unit = 'lt';
                        break;
                }
                return is_null($data->compound) ? '-' : 'added ' . $data->value . ' ' . $unit . ' ' . strtoupper($data->compound);
            })
            ->editColumn('method', function ($data) {
                return strtoupper($data->method);
            })
            ->editColumn('time', function ($data) {
                return date('H:i', strtotime($data->created_at));
            })
            ->editColumn('done_by', function ($data) {
                return $data->done_by->name;
            })
            ->editColumn('remark', function ($data) {
                return is_null($data->remark) ? '-' : $data->remark;
            })
            ->make(true);
    }
}
