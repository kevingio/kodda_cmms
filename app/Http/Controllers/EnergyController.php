<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Energy;
use App\Models\ElectricityReport;
use App\Models\GasReport;
use App\Models\WaterReport;
use DB;

class EnergyController extends Controller
{

    function __construct(Energy $energy, ElectricityReport $electricity, GasReport $gas, WaterReport $water) {
        $this->energy = $energy;
        $this->electricity = $electricity;
        $this->gas = $gas;
        $this->water = $water;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $energy = $this->energy->first();
        return view('energy-report.index', compact('energy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $energy = $this->energy->first();
        DB::transaction(function () use ($energy, $data) {
            $this->electricity->makeReport($data, $energy);
            $this->gas->makeReport($data, $energy);
            $this->water->makeReport($data, $energy);
        }, 3);
        return response()->json(['status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $energy = $this->energy->latest()->first();
        return response()->json($energy);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->energy->create($data);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    /**
     * Handle all AJAX request
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        switch ($request->mode) {
            case 'electricity':
                return $this->electricity->datatable($request->month, $request->year);
                break;
            case 'gas':
                return $this->gas->datatable($request->month, $request->year);
                break;
            case 'water':
                return $this->water->datatable($request->month, $request->year);
                break;
            case 'select2':
                return $this->{$request->type}->getYearList();
                break;
            case 'water-chart':
                return $this->energy->getWaterChart();
                break;
            case 'electricity-chart':
                return $this->energy->getElectricityChart();
                break;
        }
    }
}
