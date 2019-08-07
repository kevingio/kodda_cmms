@extends('layouts.master')
@section('content')
<div class="content-page" id="pool-page">

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Pool Management</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat {{ !empty($pool_log) && $pool_log->cl <= 3 ? 'bg-success' : 'bg-danger' }}" id="cl-card">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-speedometer float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">Chlorine</h6>
                                <h4 class="mb-4" id="cl-value">{{ !empty($pool_log->cl) ? $pool_log->cl : 'no record' }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat {{ !empty($pool_log) && $pool_log->ph >= 7.6 && $pool_log->ph <= 7.8 ? 'bg-success' : 'bg-danger' }}" id="ph-card">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-speedometer float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">pH</h6>
                                <h4 class="mb-4" id="ph-value">{{ !empty($pool_log->ph) ? $pool_log->ph : 'no record' }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <div class="card mini-stat bg-warning">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-note-outline float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">Remark</h6>
                                <h4 class="mb-4" id="remark">{{ !empty($pool_log) && $pool_log->remark != '' ? $pool_log->remark :'-' }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="row">
                                <div class="col">
                                    <div class="page-title-box p-0">
                                        <h4 class="page-title">Log History</h4>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <a href="javascript: void(0)" class="btn btn-primary mb-3 add">
                                        <i class="fas fa-plus mr-2"></i>
                                        Log
                                    </a>
                                </div>
                            </div>
                            <table id="log-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="150">Date</th>
                                        <th width="120">Time</th>
                                        <th width="130">Method</th>
                                        <th width="120">Cl</th>
                                        <th width="120">pH</th>
                                        <th>Chemical</th>
                                        <th width="170">Done by</th>
                                        <th width="200">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="page-title-box pt-0">
                                <h4 class="page-title">Cheatsheet</h4>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Cl</th>
                                                <th>ADD Chlorine</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> &#8804; 1.00 ppm</td>
                                                <td>1.00 kg</td>
                                            </tr>
                                            <tr>
                                                <td> &#8804; 1.01 - 2.00 ppm</td>
                                                <td>0.75 kg</td>
                                            </tr>
                                            <tr>
                                                <td> &#8804; 2.01 - 2.50 ppm</td>
                                                <td>0.25 kg</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-4">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>pH</th>
                                                <th>ADD Soda Ash</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>7,3</td>
                                                <td>1.00 kg</td>
                                            </tr>
                                            <tr>
                                                <td>7,2</td>
                                                <td>2.00 kg</td>
                                            </tr>
                                            <tr>
                                                <td>7,1</td>
                                                <td>3.00 kg</td>
                                            </tr>
                                            <tr>
                                                <td>7,0</td>
                                                <td>4.00 kg</td>
                                            </tr>
                                            <tr>
                                                <td>6,9</td>
                                                <td>5.00 kg</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-4">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Cl</th>
                                                <th>ADD Hydrogne Peroxide</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> 4+ 1.00 ppm</td>
                                                <td>0,25 lt</td>
                                            </tr>
                                            <tr>
                                                <td> 6+ 1.00 ppm</td>
                                                <td>0,50 lt</td>
                                            </tr>
                                            <tr>
                                                <td> 8+ 1.00 ppm</td>
                                                <td>0,75 lt</td>
                                            </tr>
                                            <tr>
                                                <td> 10+ 1.00 ppm</td>
                                                <td>1,0 lt</td>
                                            </tr>
                                            <tr>
                                                <td> 12+ 1.00 ppm</td>
                                                <td>1,25 lt</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('layouts.footer')

</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="add-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Log Pool Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Cl<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input class="form-control" name="cl" min="0" step="0.01" type="number" autocomplete="off" required>
                        </div>
                        <div class="col-sm-6">
                            <div class="row pl-sm-0">
                                <label for="example-text-input" class="col-sm-6 pl-sm-0 col-form-label">pH<span class="text-danger">*</span></label>
                                <div class="col-sm-6 pl-sm-0">
                                    <input class="form-control" name="ph" min="0" step="0.01" type="number" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Date<span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" name="date" type="text" autocomplete="off" required>
                        </div>
                        <div class="col-sm-3 pl-sm-0">
                            <input class="form-control" name="time" type="text" placeholder="hh:mm" required autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Method<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="row col-form-label">
                                <div class="col">
                                    <label class="radio-inline"><input type="radio" class="mr-2" name="method" value="manual" checked>Manual</label>
                                </div>
                                <div class="col">
                                    <label class="radio-inline"><input type="radio" class="mr-2" value="digital" name="method">Digital</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Add chemical</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="compound">
                                <option></option>
                                <option value="neo-chlorine 90">Neo-Chlorine 90</option>
                                <option value="china chlorine">China Chlorine</option>
                                <option value="china chlorine">Hydrogne Proxide</option>
                                <option value="hcl">HCL</option>
                                <option value="soda ash">Soda Ash</option>
                                <option value="pac">PAC</option>
                            </select>
                        </div>
                        <div class="col-sm-3 pl-sm-0">
                            <input class="form-control" name="value" type="text" placeholder="value" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Remark</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="remark" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
