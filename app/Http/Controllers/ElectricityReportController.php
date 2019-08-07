<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricityReport;
use App\Models\Energy;
use PDF;

class ElectricityReportController extends Controller
{

    function __construct(ElectricityReport $electricity, Energy $energy) {
        $this->electricity = $electricity;
        $this->energy = $energy;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
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
        $electricity = $this->electricity->findOrFail(decrypt($id));
        return response()->json($electricity);
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
        $report = $this->electricity->findOrFail(decrypt($id));
        $energy = $this->energy->findOrFail($report->energy_id);
        $report->updateReport($data, $energy, $report->id);
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
     * Export Water Report to PDF File
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PDF File
     */
    public function export(Request $request)
    {
        if(!empty($request->month)) {
            $reportMonth = strtotime($request->month);
            $reportData = $this->electricity->whereMonth('created_at', date('m', $reportMonth))->oldest()->get();
            $pdf = PDF::loadView('pdf.energy-report.electricity',
            [
                'reportData' => $reportData,
                'reportMonth' => date('F Y', $reportMonth)
            ]);
            return $pdf->download('electricity-report-' . date('d-m-Y') . '.pdf');
        } else {
            return redirect('/');
        }
    }
}
