<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkReport;
use App\Models\WorkOrder;
use App\Models\MaintenanceReport;

class WorkReportController extends Controller
{

    function __construct(WorkReport $work_report, WorkOrder $work_order, MaintenanceReport $mt_report) {
        $this->work_report = $work_report;
        $this->work_order = $work_order;
        $this->mt_report = $mt_report;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('work-report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maintenances = $this->mt_report->with(['equipment.equipment_model', 'equipment.location.floor', 'engineers'])
                            ->where('submitted_by', auth()->user()->id)
                            ->get();
        $work_orders = $this->work_order->with(['location.floor'])
                            ->whereHas('engineers', function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            })
                            ->get();
        return view('work-report.create', compact('maintenances', 'work_orders'));
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
        $data['user_id'] = auth()->user()->id;
        $this->work_report->updateOrCreate($data);
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
        $work_report = $this->work_report->with('user.job.department')->findOrFail(decrypt($id));
        return response()->json($work_report);
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
        $this->work_report->findOrFail(decrypt($id))->update($data);
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
        $this->work_report->findOrFail(decrypt($id))->delete();
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
                return $this->work_report->datatable();
                break;
        }
    }
}
