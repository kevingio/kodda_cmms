<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceReport;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryReport;

class MaintenanceReportController extends Controller
{

    function __construct(MaintenanceReport $maintenance_report, User $user, Inventory $inventory, InventoryReport $inventory_report) {
        $this->maintenance_report = $maintenance_report;
        $this->user = $user;
        $this->inventory = $inventory;
        $this->inventory_report = $inventory_report;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('maintenance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
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
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date = $this->maintenance_report->validateDate($id);
        if($date === true) {
            $date = $id;
            $engineers = $this->user->getUserByRole(4);
            return view('maintenance.report-list', compact('date', 'engineers'));
        } else {
            $mt_report = $this->maintenance_report->with(['equipment.model.maintenance_tasks', 'equipment.location.floor'])->findOrFail(decrypt($id));
            $mt_report->getAllEnginersExceptMe();
            return response()->json($mt_report);
        }
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
        $user_ids[] = auth()->user()->id;
        if(!empty($data['co_workers'])) {
            foreach ($data['co_workers'] as $value) {
                $user_ids[] = $value;
            }
        }
        $engineers = $this->user->findOrFail($user_ids);
        $mt_report = $this->maintenance_report->findOrFail(decrypt($id));
        if($request->has('inventories')) {
            $inventories = json_decode($data['inventories']);
            foreach ($inventories as $inventory) {
                if ($this->inventory->reduceInventory($inventory)) {
                    $this->inventory_report->makeReport($inventory, 2, $mt_report->id);
                }
            }
        }
        $mt_report->insertEngineers($data, $engineers)->update($data);
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
            case 'datatable':
                return $this->maintenance_report->datatable($request->date);
                break;
        }
    }
}
