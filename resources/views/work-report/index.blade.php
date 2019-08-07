@extends('layouts.master')
@section('content')
<div class="content-page" id="work-report-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-title-box">
                        <h4 class="page-title">Daily Activity</h4>
                    </div>
                </div>
                @if(!in_array(auth()->user()->role_id, [1,2]))
                <div class="col d-inline d-sm-none text-right">
                    <div class="page-title-box ">
                        <a href="{{ route('work-report.create') }}" class="btn btn-primary">Create Work Report</a>
                    </div>
                </div>
                @endif
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">

                            <table id="work-report-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th width="250">Name</th>
                                    <th class="no-sort">Department</th>
                                    <th class="no-sort">Job Title</th>
                                    <th width="150">Work Date</th>
                                    <th width="180">Submitted at</th>
                                    <th width="100" class="text-center no-sort no-search">Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('layouts.footer')
</div>

<!-- Detail Work Report Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title m-0">Detail Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="example-url-input" class="col-sm-2 col-form-label">Employee Name</label>
                    <div class="col-sm-3">
                        <strong class="form-control-plaintext" name="name"></strong>
                    </div>
                    <label for="example-url-input" class="col-sm-2 col-form-label offset-sm-2">Department</label>
                    <div class="col-sm-3">
                        <strong class="form-control-plaintext" name="department"></strong>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-sm-2 col-form-label">Job Title</label>
                    <div class="col-sm-3">
                        <strong class="form-control-plaintext" name="job"></strong>
                    </div>
                    <label for="example-text-input" class="col-sm-2 col-form-label offset-sm-2">Work Date</label>
                    <div class="col-sm-3">
                        <strong class="form-control-plaintext" name="work_date"></strong>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-url-input" class="col-sm-2 col-form-label">Activity</label>
                    <div class="col-sm-10">
                        <strong class="form-control-plaintext" name="activity"></strong>
                    </div>
                </div>
                <div class="row">
                    <label for="example-url-input" class="col-sm-2 col-form-label">Submitted at</label>
                    <div class="col-sm-10">
                        <strong class="form-control-plaintext" name="submitted"></strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
