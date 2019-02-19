<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use App\Models\MaintenanceReport;
use App\Models\Location;

class EquipmentController extends Controller
{

    function __construct(Equipment $equipment, EquipmentModel $equipment_model, Location $location, MaintenanceReport $mt_report) {
        $this->equipment = $equipment;
        $this->equipment_model = $equipment_model;
        $this->location = $location;
        $this->mt_report = $mt_report;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment_models = $this->equipment_model->all();
        $locations = $this->location->with('floor')->get();
        return view('equipment.index', compact('equipment_models', 'locations'));
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
        $equipment = $this->equipment->updateOrCreate($data);
        $this->mt_report->makeMaintenanceReportFor($equipment);
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
        $equipment = $this->equipment->findOrFail(decrypt($id));
        return response()->json($equipment);
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
        $this->equipment->findOrFail(decrypt($id))->update($data);
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
        $this->equipment->findOrFail(decrypt($id))->delete();
        return response()->json(['status' => 200]);
    }

    /**
     * Handle all AJAX request
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        switch ($request->mode) {
            case 'datatable':
                return $this->equipment->datatable();
                break;
            case 'maintenance':
                return $this->equipment->maintenance();
                break;
        }
    }
}
