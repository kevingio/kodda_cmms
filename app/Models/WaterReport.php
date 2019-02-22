<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class WaterReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pdam',
        'pdam_consumption',
        'pdam_cost',
        'pdam_month_to_date',
        'deep_well',
        'deep_well_consumption',
        'deep_well_cost',
        'deep_well_month_to_date',
        'occupancy',
        'water_per_room',
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
     * Calculate PDAM Consumption
     *
     * @param float $current_consumption
     * @return float
     */
    public function calculatePdamConsumption($current_consumption)
    {
        $lastRecord = $this->first();
        return $lastRecord ? $current_consumption - $lastRecord->pdam : $current_consumption;
    }

    /**
     * Calculate PDAM Cost
     *
     * @param float $pdam
     * @return float
     */
    public function calculatePdamCost($pdam)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        return $dayDiff * $pdam;
    }

    /**
     * Calculate PDAM Month to Date Cost
     *
     * @param float $current_cost
     * @return float
     */
    public function calculatePdamMonthToDateCost($current_cost)
    {
        $lastRecords = Self::whereMonth('created_at', date('m'))->get();
        $monthToDateCost = 0;
        foreach ($lastRecords as $record) {
           $monthToDateCost += $record->pdam_cost;
        }
        $monthToDateCost += $current_cost;
        return $monthToDateCost;
    }

    /**
     * Calculate Deep Well Consumption
     *
     * @param float $current_consumption
     * @return float
     */
    public function calculateDeepWellConsumption($current_consumption)
    {
        $lastRecord = $this->first();
        return $lastRecord ? $current_consumption - $lastRecord->deep_well : $current_consumption;
    }

    /**
     * Calculate Deep Well Cost
     *
     * @param float $deep_well
     * @return float
     */
    public function calculateDeepWellCost($deep_well)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        return $dayDiff * $deep_well;
    }

    /**
     * Calculate Deep Well Month to Date Cost
     *
     * @param float $current_cost
     * @return float
     */
    public function calculateDeepWellMonthToDateCost($current_cost)
    {
        $lastRecords = Self::whereMonth('created_at', date('m'))->get();
        $monthToDateCost = 0;
        foreach ($lastRecords as $record) {
           $monthToDateCost += $record->deep_well_cost;
        }
        $monthToDateCost += $current_cost;
        return $monthToDateCost;
    }

    /**
     * Make new water report
     *
     * @param array $data
     */
    public function makeReport($input, $energy) {
        $data['occupancy'] = $input['occupancy'];
        $data['pdam'] = $input['pdam'];
        $data['pdam_consumption'] = $this->calculatePdamConsumption($data['pdam']);
        $data['pdam_cost'] = $this->calculatePdamCost($energy->pdam);
        $data['pdam_month_to_date'] = $this->calculatePdamMonthToDateCost($data['pdam_cost']);
        $data['deep_well'] = $input['deep_well'];
        $data['deep_well_consumption'] = $this->calculateDeepWellConsumption($data['deep_well']);
        $data['deep_well_cost'] = $this->calculateDeepWellCost($energy->deep_well);
        $data['deep_well_month_to_date'] = $this->calculateDeepWellMonthToDateCost($data['deep_well_cost']);
        $data['water_per_room'] = ($data['pdam_cost'] + $data['deep_well_cost']) / $data['occupancy'];
        $this->updateOrCreate($data);
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
        $results = Self::whereMonth('created_at', $month)->whereYear('created_at', $year)->latest()->get();
        return Datatables::of($results)
            ->editColumn('day', function ($data) {
                return date('d', strtotime($data->created_at));
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-id="' . encrypt($data->id) . '" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>';
                return in_array(auth()->user()->role_id, [1,2]) ? $html : '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
