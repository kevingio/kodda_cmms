<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Yajra\Datatables\Datatables;
use DateTime;

class MaintenanceReport extends Model
{
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'mt_number',
        'equipment_id',
        'status',
        'submitted_by',
        'description',
        'created_at',
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
     * Relation to equipment
     *
     */
    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment')->withTrashed();
    }
    /**
     * Relation to users
     *
     */
    public function engineers()
    {
        return $this->belongsToMany('App\Models\User', 'maintenance_report_users');
    }

    /**
     * Retrieve engineer ids
     *
     */
    public function engineer_ids()
    {
        return $this->belongsToMany('App\Models\User', 'maintenance_report_users')->withPivot('user_id');
    }

    /**
     * Retrieve inventory report
     *
     */
    public function inventory_reports()
    {
        return $this->hasMany('App\Models\InventoryReport', 'resource_id')->where('type', 2);
    }

    /**
     * Insert engineers to DB
     *
     * @param array $engineers
     */
    function insertEngineers($data, $engineers)
    {
        $this->engineers()->detach($this->engineers);
        if($data['status'] == 'not started') {
            $data['submitted_by'] = NULL;
            $data['comment'] = NULL;
        } else {
            $data['submitted_by'] = auth()->id();
            $this->engineers()->attach($engineers);
        }
        return $this;
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
        foreach ($this->engineers as $key => $engineer) {
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
     * Generate maintenance number
     *
     */
    public function generateMaintenanceNumber()
    {
        $last_record = Self::latest()->value('mt_number');
        if($last_record) {
            $substring = substr($last_record, 2, 5);
            $toInt = intval($substring);
        } else {
            $toInt = 0;
        }
        $new_mt_number = 'MT' . str_pad($toInt + 1, 5, '0', STR_PAD_LEFT);
        return $new_mt_number;
    }

    /**
     * Check if input is valid date format
     *
     */
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Check if input is valid date format
     *
     * @param Datetime $current_date
     * @param integer $maintenance_period
     */
    function getNextMaintenanceDate($current_date, $maintenance_period)
    {
        return date('Y-m-d H:i:s', strtotime('+' . $maintenance_period . 'month', strtotime($current_date)));
    }

    /**
     * Make report for certain period (month)
     *
     * @param App\Models\Equipment $equipment
     * @param int $month
     */
    function makeMaintenanceReportFor($equipment, $month = 48, $iteration = 1)
    {
        if($month < $equipment->maintenance_period) {
            return;
        } else {
            Self::updateOrCreate([
                'mt_number' => $this->generateMaintenanceNumber(),
                'equipment_id' => $equipment->id,
                'created_at' => $this->getNextMaintenanceDate($equipment->created_at, $iteration * $equipment->maintenance_period)
            ]);
            return $this->makeMaintenanceReportFor($equipment, $month - $equipment->maintenance_period, $iteration + 1);
        }
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable($date)
    {
        $results = Self::with(['equipment.location.floor', 'equipment.model'])->whereDate('created_at', $date)->get();
        return Datatables::of($results)
            ->editColumn('location', function ($data) {
                return $data->equipment->location->area . ' - ' . $data->equipment->location->floor->description;
            })
            ->editColumn('model', function ($data) {
                return $data->equipment->model->name;
            })
            ->editColumn('serial_number', function ($data) {
                return $data->equipment->serial_number;
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
                $html = '';
                if(in_array(auth()->id(), [4,6]) && $data->status != 'completed' && ($data->submitted_by == auth()->id() || is_null($data->submitted_by))) {
                    $html = '
                    <a href="javascript: void(0)" class="btn btn-success finish waves-effect waves-light" data-id="'.encrypt($data->id).'">
                        <i class="mdi mdi-check font-weight-bold"></i>
                    </a>';
                }
                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

}
