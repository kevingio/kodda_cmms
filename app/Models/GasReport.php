<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class GasReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'consumption',
        'cost',
        'month_to_date',
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
     * Calculate Gas Consumption
     *
     * @param float $current_consumption
     * @return float
     */
    public function calculateGasConsumption($current_consumption)
    {
        $lastRecord = $this->first();
        return $lastRecord ? $current_consumption - $lastRecord->consumption : $current_consumption;
    }

    /**
     * Calculate Gas Cost
     *
     * @param float $lwbp
     * @return float
     */
    public function calculateGasCost($lpg)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        return $dayDiff * $lpg;
    }

    /**
     * Calculate Month To Date Cost
     *
     * @param float $current_cost
     * @return float
     */
    public function calculateMonthToDateCost($current_cost)
    {
        $lastRecords = $this->whereMonth('created_at', date('m'))->get();
        $monthToDateCost = 0;
        foreach ($lastRecords as $record) {
           $monthToDateCost += $record->cost;
        }
        $monthToDateCost += $current_cost;
        return $monthToDateCost;
    }

    /**
     * Make new electricity report
     *
     * @param array $data
     */
    public function makeReport($input, $energy) {
        $data['value'] = $input['lpg'];
        $data['consumption'] = $this->calculateGasConsumption($data['value']);
        $data['cost'] = $this->calculateGasCost($energy->lpg);
        $data['month_to_date'] = $this->calculateMonthToDateCost($data['cost']);
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
        $results = $this->whereMonth('created_at', $month)->whereYear('created_at', $year)->latest()->get();
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
