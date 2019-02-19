<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use DB;

class WorkOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'submitted_by',
        'wo_number',
        'task',
        'status',
        'location_id',
        'due_date',
        'priority',
        'image',
        'comment',
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
     * Relation to department
     *
     */
    public function assignor()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id')->withTrashed();
    }

    /**
     * Relation to department
     *
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location')->withTrashed();
    }

    /**
     * Relation to users
     *
     */
    public function engineers()
    {
        return $this->belongsToMany('App\Models\User', 'work_order_users');
    }

    /**
     * Retrieve engineer ids
     *
     */
    public function engineer_ids()
    {
        return $this->belongsToMany('App\Models\User', 'work_order_users')->withPivot('user_id');
    }

    /**
     * Retrieve inventory report
     *
     */
    public function inventory_reports()
    {
        return $this->hasMany('App\Models\InventoryReport', 'resource_id')->where('type', 1);
    }

    /**
     * Get image public path
     *
     */
    public function getImagePath()
    {
        $this->image = Storage::url($this->image);
        return $this;
    }

    /**
     * Check if record has image
     *
     */
    public function hasImage()
    {
        return is_null($this->image) ? $this : $this->getImagePath();
    }

    /**
     * Format due date
     *
     */
    public function formatDueDate()
    {
        return $this->due_date_formatted = date('l, dS F Y', strtotime($this->due_date));
    }

    /**
     * Get all engineers except logged in user (array and string)
     *
     * @return array()
     */
    public function getAllEnginersExceptMe()
    {
        $engineers = [];
        $engineers_in_string = '';
        foreach ($this->engineers as $engineer) {
            if($engineer->id != auth()->user()->id) {
                $engineers[] = $engineer->id;
                $engineers_in_string .= $engineer->name;
                if($key >= 1) {
                    $engineers_in_string .= ', ';
                }
            }
        }
        unset($this->engineers);
        $this->engineers = $engineers;
        $this->engineers_in_string = $engineers_in_string;
        return $this;
    }

    /**
     * Generate work order number
     *
     */
    public function generateWorkOrderNumber()
    {
        $last_record = Self::latest()->value('wo_number');
        if($last_record) {
            $substring = substr($last_record, 2, 5);
            $toInt = intval($substring);
        } else {
            $toInt = 0;
        }
        $new_wo_number = 'WO' . str_pad($toInt + 1, 5, '0', STR_PAD_LEFT);
        return $new_wo_number;
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function getStatusToday()
    {
        $role = auth()->user()->role_id;
        if($role == 3) {
            $statuses = Self::select('status', DB::raw('count(*) as count'))
                                ->groupBy('status')
                                ->where('created_by', auth()->user()->id)
                                ->whereDate('created_at', date('Y-m-d'))
                                ->get();
        } else {
            $statuses = Self::select('status', DB::raw('count(*) as count'))
                            ->groupBy('status')
                            ->whereDate('created_at', date('Y-m-d'))
                            ->get();
        }
        $data = [];
        $total = 0;
        foreach ($statuses as $value) {
            $data[str_slug($value->status)] = $value->count;
            $total += $value->count;
        }
        $data['total'] = $total;
        return $data;
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable($type)
    {
        if($type == 'history') {
            $datas = Self::with(['assignor', 'location.floor'])->orderBy('created_at', 'desc')->get();
        } else {
            $datas = Self::with(['assignor', 'location.floor'])->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        }
        return Datatables::of($datas)
            ->editColumn('task', function ($data) {
                $html = '';
                if(!empty($data->image)) {
                    $html = '<img src="' . Storage::url($data->image) . '" alt="thumbnail" class="thumb-md rounded-circle mr-2"/>';
                }
                return $html . $data->task;
            })
            ->editColumn('location', function ($data) {
                return $data->location->area . ' - ' . $data->location->floor->description;
            })
            ->editColumn('due_date', function ($data) {
                return date('Y-m-d', strtotime($data->due_date));
            })
            ->editColumn('priority', function ($data) {
                switch ($data->priority) {
                    case 'low':
                        $priority = 'text-success';
                        break;

                    case 'medium':
                        $priority = 'text-warning';
                        break;

                    case 'high':
                        $priority = 'text-danger';
                        break;
                }
                $html = '<i class="mdi mdi-checkbox-blank-circle ' . $priority . '"></i> ';
                return $html . ucwords($data->priority);
            })
            ->editColumn('status', function ($data) {
                switch ($data->status) {
                    case 'not started':
                        $status = 'badge-danger';
                        break;

                    case 'in progress':
                        $status = 'badge-primary';
                        break;

                    case 'waiting for quotation':
                    case 'waiting for part':
                        $status = 'badge-warning';
                        break;

                    case 'completed':
                        $status = 'badge-success';
                        break;
                }
                $html = '<span class="badge badge-pill ' . $status . '">' . ucfirst($data->status) . '</span> ';
                return $html;
            })
            ->editColumn('action', function ($data) {
                $role = auth()->user()->role_id;
                $html = '
                <a href="javascript: void(0)" class="btn btn-info info waves-effect waves-light" data-id="'.encrypt($data->id).'">
                    <i class="mdi mdi-information"></i>
                </a>';
                if($role == 4 && $data->status != 'completed' && ($data->submitted_by == auth()->user()->id || empty($data->submitted_by))) {
                    $html = $html . '
                    <a href="javascript: void(0)" class="btn btn-success finish waves-effect waves-light" data-id="'.encrypt($data->id).'">
                        <i class="mdi mdi-check font-weight-bold"></i>
                    </a>';
                } elseif ($role == 3 && $data->status == 'not started') {
                    $html = $html . '
                    <a href="javascript: void(0)" class="btn btn-danger delete waves-effect waves-light" data-id="'.encrypt($data->id).'">
                        <i class="mdi mdi-delete"></i>
                    </a>';
                }
                return $html;
            })
            ->rawColumns(['task' ,'priority', 'status', 'action'])
            ->make(true);
    }
}
