<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\PoolLog;
use App\Models\InventoryReport;
use App\Models\MaintenanceReport;
use Image;
use PDF;

class HomeController extends Controller
{

    function __construct(User $user, WorkOrder $workOrder, PoolLog $poolLog, InventoryReport $inventory, MaintenanceReport $mtReport) {
        $this->user = $user;
        $this->workOrder = $workOrder;
        $this->log = $poolLog;
        $this->inventory = $inventory;
        $this->mtReport = $mtReport;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_id = auth()->user()->role_id;
        switch ($role_id) {
            case 3:
            case 4:
                return redirect()->route('work-order.index');
                break;
            case 6:
                return redirect()->route('inventory.index');
                break;
        }
        $maintenances = $this->mtReport->where('status', 'completed')->get();
        $workOrderStatus = $this->workOrder->getStatusThisMonth();
        $poolLog = $this->log->latest()->first();
        $inventoryIn = $this->inventory->with('inventory.inventory_model')->where('mode', 'in')->whereMonth('created_at', date('m'))->get();
        $inventoryOut = $this->inventory->with('inventory.inventory_model')->where('mode', 'out')->whereMonth('created_at', date('m'))->get();
        return view('dashboard.index', compact('workOrderStatus', 'poolLog', 'inventoryIn', 'inventoryOut', 'maintenances'));
    }

    /**
     * Update user profile
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $data = $request->except('avatar');
        $user = $this->user->findOrFail(auth()->user()->id);
        if($request->hasFile('avatar')) {
            if($user->avatar) {
                Storage::delete($user->avatar);
            }
            $image = $request->file('avatar');
            $filename = str_random(28) . '.' . $image->extension();
            $path = 'public/avatars/' . $filename;
            $file = Image::make($image->getRealPath())->fit(500,500);
            Storage::put($path, (string) $file->encode());

            $data['avatar'] = Storage::url($path);
        }
        $user->update($data);
        return response()->json(['name' => $data['name'], 'avatar' => $request->hasFile('avatar') ? $data['avatar'] : null]);
    }

    public function export()
    {
        $data['workOrderStatus'] = $this->workOrder->getStatusToday();
        $data['poolLog'] = $this->log->latest()->first();
        $pdf = PDF::loadView('pdf.summary', $data);
        return $pdf->download('summary.pdf');
        // return view('pdf.summary', compact($data));
    }
}
