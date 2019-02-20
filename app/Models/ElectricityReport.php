<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class ElectricityReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lwbp',
        'lwbp_total',
        'lwbp_price',
        'wbp',
        'wbp_total',
        'wbp_price',
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
     * Calculate LWBP Price
     *
     * @param float $lwbp
     * @return float
     */
    public function calculateLwbpPrice($lwbp)
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $lwbp * $x;
    }

    /**
     * Calculate WBP Total
     *
     * @return float $wbp
     */
    public function calculateWbpTotal()
    {
        $dayDiff = date('d') - date('d', strtotime('-1 day'));
        $x = 2000;
        return $dayDiff * $x;
    }

    /**
     * Calculate WBP Price
     *
     * @param float $wbp
     * @return float
     */
    public function calculateWbpPrice($wbp)
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
    public function calculateMonthToDateCost($current_cost)
    {
        $lastRecords = Self::whereMonth('created_at', date('d'))->get();
        $monthToDateCost = 0;
        foreach ($lastRecords as $record) {
           $monthToDateCost += $record->cost_total;
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
        $data['lwbp'] = $input['lwbp'];
        $data['wbp'] = $input['wbp'];
        $data['occupancy'] = $input['occupancy'];
        $data['lwbp_total'] = $this->calculateLwbpTotal();
        $data['lwbp_price'] = $this->calculateLwbpPrice($energy->lwbp);
        $data['wbp_total'] = $this->calculateWbpTotal();
        $data['wbp_price'] = $this->calculateWbpPrice($energy->wbp);
        $data['cost_total'] = $data['lwbp_price'] + $data['wbp_price'];
        $data['electricity_per_room'] = $data['cost_total'] / $data['occupancy'];
        $data['month_to_date_cost'] = $this->calculateMonthToDateCost($data['cost_total']);
        $this->updateOrCreate($data);
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable($month, $year)
    {
        $results = $this->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
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
