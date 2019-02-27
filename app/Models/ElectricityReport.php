<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ElectricityReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'energy_id',
        'lwbp',
        'lwbp_total',
        'lwbp_cost',
        'wbp',
        'wbp_total',
        'wbp_cost',
        'cost_total',
        'occupancy',
        'electricity_per_room',
        'month_to_date_cost',
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
     * Calculate LWBP Total
     *
     * @return float
     */
    public function calculateLwbpTotal()
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $x;
    }

    /**
     * Calculate LWBP Cost
     *
     * @param float $lwbp
     * @return float
     */
    public function calculateLwbpCost($lwbp)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $lwbp * $x;
    }

    /**
     * Calculate WBP Total
     *
     * @return float
     */
    public function calculateWbpTotal()
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $x;
    }

    /**
     * Calculate WBP Cost
     *
     * @param float $wbp
     * @return float
     */
    public function calculateWbpCost($wbp)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $wbp * $x;
    }

    /**
     * Calculate Month To Date Cost
     *
     * @param float $current_cost
     * @return float
     */
    public function calculateMonthToDateCost($current_cost, $report_id = null)
    {
        if($report_id) {
            $lastRecords = Self::whereMonth('created_at', date('m'))->where('id', '!=', $report_id)->get();
        } else {
            $lastRecords = Self::whereMonth('created_at', date('m'))->get();
        }
        $monthToDateCost = 0;
        foreach ($lastRecords as $record) {
           $monthToDateCost += $record->cost_total;
        }
        $monthToDateCost += $current_cost;
        return $monthToDateCost;
    }

    /**
     * Process input to correct field in database
     *
     * @param array $input
     * @param App\Models\Energy $energy
     * @return array
     */
    public function processInput($input, $energy, $report_id = null)
    {
        $data['energy_id'] = $energy->id;
        $data['lwbp'] = $input['lwbp'];
        $data['wbp'] = $input['wbp'];
        $data['occupancy'] = $input['occupancy'];
        $data['lwbp_total'] = $this->calculateLwbpTotal();
        $data['lwbp_cost'] = $this->calculateLwbpCost($energy->lwbp);
        $data['wbp_total'] = $this->calculateWbpTotal();
        $data['wbp_cost'] = $this->calculateWbpCost($energy->wbp);
        $data['cost_total'] = $data['lwbp_cost'] + $data['wbp_cost'];
        $data['electricity_per_room'] = $data['cost_total'] / $data['occupancy'];
        $data['month_to_date_cost'] = $this->calculateMonthToDateCost($data['cost_total'], $report_id);
        return $data;
    }

    /**
     * Make new electricity report
     *
     * @param array $input
     * @param App\Models\Energy $energy
     */
    public function makeReport($input, $energy) {
        $data = $this->processInput($input, $energy);
        $this->updateOrCreate($data);
    }

    /**
     * Update specified electricity report
     *
     * @param array $input
     * @param App\Models\Energy $energy
     */
    public function updateReport($input, $energy, $report_id) {
        $data = $this->processInput($input, $energy, $report_id);
        $this->update($data);
    }

    /**
     * Get year list from submitted report
     *
     * @return array $years
     */
    public function getYearList() {
        $results = $this
                    ->get(['id'])
                    ->groupBy(function ($value) {
                        return Carbon::parse($value->created_at)->format('Y');
                    });
        if(!$results) {
            $years = [
                'id' => date('Y'),
                'text' => date('Y')
            ];
        }
        foreach ($results as $key => $result) {
            $years[] = [
                'id' => $key,
                'text' => $key
            ];
        }
        return $years;
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable($month, $year)
    {
        $results = $this->whereMonth('created_at', $month)->whereYear('created_at', $year)->latest()->get();
        return Datatables::of($results)
            ->editColumn('day', function ($data) {
                return date('d', strtotime($data->created_at));
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit-electricity waves-effect waves-light" data-id="' . encrypt($data->id) . '">
                    <i class="mdi mdi-pencil"></i>
                </a>';
                return in_array(auth()->user()->role_id, [1,2]) ? $html : '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
