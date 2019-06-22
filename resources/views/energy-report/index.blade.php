@extends('layouts.master')
@section('content')
<div class="content-page" id="energy-report-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-title-box">
                        <h4 class="page-title" @if(in_array(auth()->user()->role_id, [1,2])) id="admin" @endif>Energy Report</h4>
                    </div>
                </div>
                <div class="col text-right">
                    <div class="page-title-box ">
                        <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Create
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a href="javascript: void(0)" class="dropdown-item" data-toggle="modal" data-target="#addModal">Create Report</a>
                            <a href="javascript: void(0)" class="dropdown-item edit">Update Energy</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill nav-energy">
                                <li class="nav-item">
                                    <a class="nav-link active" id="electricity-tab" data-toggle="tab" href="#electricity-pane">Electricity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="water-tab" data-toggle="tab" href="#water-pane">Water</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="gas-tab" data-toggle="tab" href="#gas-pane">Gas</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="electricity-pane" role="tabpanel" aria-labelledby="home-tab">@include('energy-report.electricity')</div>
                                <div class="tab-pane" id="water-pane" role="tabpanel" aria-labelledby="profile-tab">@include('energy-report.water')</div>
                                <div class="tab-pane" id="gas-pane" role="tabpanel" aria-labelledby="messages-tab">@include('energy-report.gas')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- Create Energy Report Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Create Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="col-form-label">LWBP<span class="text-danger">*</span></label>
                            <input class="form-control" name="lwbp" type="text" required autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label">WBP<span class="text-danger">*</span></label>
                            <input class="form-control" name="wbp" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="col-form-label">PDAM<span class="text-danger">*</span></label>
                            <input class="form-control" name="pdam" type="text" required autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label">Deep Well<span class="text-danger">*</span></label>
                            <input class="form-control" name="deep_well" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="col-form-label">LPG/CNG<span class="text-danger">*</span></label>
                            <input class="form-control" name="lpg" type="text" required autocomplete="off">
                        </div>
                        <div class="form-group col">
                            <label class="col-form-label">Occupancy<span class="text-danger">*</span></label>
                            <input class="form-control" name="occupancy" type="text" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Energy Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Update Energy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="col-form-label">LWBP<span class="text-danger">*</span></label>
                            <input class="form-control" name="lwbp" type="text" required autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label">WBP<span class="text-danger">*</span></label>
                            <input class="form-control" name="wbp" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label class="col-form-label">PDAM<span class="text-danger">*</span></label>
                            <input class="form-control" name="pdam" type="text" required autocomplete="off">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label">Deep Well<span class="text-danger">*</span></label>
                            <input class="form-control" name="deep_well" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="col-form-label">LPG/CNG<span class="text-danger">*</span></label>
                            <input class="form-control" name="lpg" type="text" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
