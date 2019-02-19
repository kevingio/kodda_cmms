<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkOrder;
use App\Models\Inventory;
use App\Models\InventoryReport;
use App\Models\Location;
use App\Models\User;
use Image;

class WorkOrderController extends Controller
{

    function __construct(WorkOrder $work_order, Location $location, User $user, Inventory $inventory, InventoryReport $inventory_report) {
        $this->work_order = $work_order;
        $this->location = $location;
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
        $data = $this->work_order->getStatusToday();
        $locations = $this->location->with('floor')->get();
        if(auth()->user()->role_id == 4) {
            $engineers = $this->user->getUserByRole(4);
            return view('work-order.index', compact('locations', 'data', 'engineers'));
        } else {
            return view('work-order.index', compact('locations', 'data'));
        }
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
        $data = $request->except('image');
        $data['created_by'] = auth()->user()->id;
        $data['due_date'] = date('Y-m-d', strtotime($data['due_date']));
        $data['wo_number'] = $this->work_order->generateWorkOrderNumber();
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = str_random(28) . '.jpg';
            $path = 'storage/work_orders/' . $filename;
            $file = Image::make($image->getRealPath())->encode('jpg',75);
            $file->save($path);
            $data['image'] = str_replace('storage', 'public', $path);
        }
        $this->work_order->create($data);
        $status = $this->work_order->getStatusToday();
        return response()->json($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work_order = $this->work_order->with(['assignor', 'location.floor'])->findOrFail(decrypt($id));
        $work_order->hasImage()->getAllEnginersExceptMe()->formatDueDate();
        return response()->json($work_order);
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
        $data['submitted_by'] = auth()->user()->id;
        if(!empty($data['co_workers'])) {
            foreach ($data['co_workers'] as $value) {
                $user_ids[] = $value;
            }
        }
        $engineers = $this->user->findOrFail($user_ids);
        $work_order = $this->work_order->findOrFail(decrypt($id));
        $work_order->engineers()->detach($work_order->engineers);
        if($data['status'] == 'not started') {
            $data['submitted_by'] = NULL;
            $data['comment'] = NULL;
        } else {
            $work_order->engineers()->attach($engineers);
        }
        if($request->has('inventories')) {
            $inventories = json_decode($data['inventories']);
            foreach ($inventories as $inventory) {
                if ($this->inventory->reduceInventory($inventory)) {
                    $this->inventory_report->makeReport($inventory, 1, $work_order->id);
                }
            }
        }
        $work_order->update($data);
        $status = $this->work_order->getStatusToday();
        return response()->json($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work_order = $this->work_order->findOrFail(decrypt($id));
        if(!empty($work_order->image)) {
            Storage::delete($work_order->image);
        }
        $work_order->delete();
        $status = $this->work_order->getStatusToday();
        return response()->json($status);
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
                return $this->work_order->datatable($request->type);
                break;
        }
    }
}
