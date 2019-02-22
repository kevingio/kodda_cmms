<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\Datatables\Datatables;

class Inventory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'inventory_model_id',
        'qty',
        'min_stock',
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
     * Relation to inventory model
     *
     */
    public function inventory_model()
    {
        return $this->belongsTo('App\Models\InventoryModel');
    }

    /**
     * Reduce inventory
     *
     * @param App\Models\Inventory $inventory
     */
    public function reduceInventory($inventory)
    {
        return $this->findOrFail($inventory->id)->decrement('qty', $inventory->qty);
    }

    /**
     * Get Datatable Data
     * @return array
     */
    public function datatable()
    {
        $results = $this->with('inventory_model')->get();
        return Datatables::of($results)
            ->editColumn('model', function ($data) {
                return $data->inventory_model->name;
            })
            ->editColumn('status', function ($data) {
                $stock_diff = $data->qty - $data->min_stock;
                $html = '<span class="badge badge-pills badge-success">Good</span>';
                if($stock_diff < 0) {
                    $html = '<span class="badge badge-pills badge-danger">Need to be restocked</span>';
                } elseif ($stock_diff == 0) {
                    $html = '<span class="badge badge-pills badge-warning">Warning</span>';
                }
                return $html;
            })
            ->editColumn('action', function ($data) {
                $html = '
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger delete waves-effect waves-light" data-id="'.encrypt($data->id).'" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>';
                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Get Datatable Data
     * @param string $query
     * @return array
     */
    public function select2($query)
    {
        $data = $this->where('name', 'like', "%{$query}%")->get();
        $results = [];
        foreach ($data as $value) {
            $results[] = [
                'id' => $value->id,
                'text' => $value->name,
                'qty' => $value->qty
            ];
        }
        return response()->json($results);
    }
}
