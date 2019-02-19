<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\InventoryModel;
use App\Models\InventoryReport;

class InventoryController extends Controller
{

    function __construct(Inventory $inventory, InventoryModel $inventory_model, InventoryReport $inventory_report) {
        $this->inventory = $inventory;
        $this->inventory_model = $inventory_model;
        $this->inventory_report = $inventory_report;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory_models = $this->inventory_model->all();
        return view('inventory.index', compact('inventory_models'));
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
        $created_record = $this->inventory->create($data);
        if($created_record) {
            $this->inventory_report->create([
                'inventory_id' => $created_record->id,
                'qty' => $data['qty'],
                'type' => 3,
                'resource_id' => auth()->user()->id,
            ]);
        }
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
        $inventory = $this->inventory->findOrFail(decrypt($id));
        return response()->json($inventory);
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
        $this->inventory->findOrFail(decrypt($id))->update($data);
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
        $deleted = $this->inventory->findOrFail(decrypt($id))->delete();
        if($deleted) {
            $this->inventory_report->create([
                'inventory_id' => $created_record->id,
                'qty' => $data['qty'],
                'type' => 3,
                'mode' => 'delete',
                'resource_id' => auth()->user()->id,
            ]);
        }
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
                return $this->inventory->datatable();
                break;
            case 'select2':
                return $this->inventory->select2($request->search);
                break;
        }
    }
}
