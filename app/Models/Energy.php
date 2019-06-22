<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Energy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lwbp',
        'wbp',
        'pdam',
        'deep_well',
        'lpg',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Get Water Data
     * @return array
     */
    public function getWaterChart()
    {
        $waterData = $this->get(['pdam', 'deep_well', 'created_at']);
        $dates = ['x'];
        $pdamPrices = ['PDAM'];
        $deepWellPrices = ['Deep Well'];
        foreach ($waterData as $key => $value) {
            $dates[] = date('Y-m-d', strtotime($value->created_at));
            $pdamPrices[] = $value->pdam;
            $deepWellPrices[] = $value->deep_well;
        }
        return [
            'pdam' => $pdamPrices,
            'deep_well' => $deepWellPrices,
            'dates' => $dates
        ];
    }
    /**
     * Get Water Data
     * @return array
     */
    public function getElectricityChart()
    {
        $electricityData = $this->get(['lwbp', 'wbp', 'created_at']);
        $dates = ['x'];
        $lwbpPrices = ['LWBP'];
        $wbpPrices = ['WBP'];
        foreach ($electricityData as $key => $value) {
            $dates[] = date('Y-m-d', strtotime($value->created_at));
            $lwbpPrices[] = $value->lwbp;
            $wbpPrices[] = $value->wbp;
        }
        return [
            'lwbp' => $lwbpPrices,
            'wbp' => $wbpPrices,
            'dates' => $dates
        ];
    }
}
