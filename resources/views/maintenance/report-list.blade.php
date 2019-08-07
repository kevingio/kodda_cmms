@extends('layouts.master')
@section('content')
<div class="content-page" id="maintenance-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <span class="d-none" id="date">{{ $date }}</span>
                        <h4 class="page-title">Maintenance Report on <span>{{ date('F d, Y', strtotime($date)) }}<span></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vertical" id="maintenance-list-datatable">
                                    <thead>
                                        <tr class="font-weight-bold">
                                            <th width="170">MT Number</th>
                                            <th width="180" class="no-sort">Model</th>
                                            <th class="no-sort no-search">Serial Number</th>
                                            <th width="200" class="no-sort no-search">Location</th>
                                            <th width="150" class="no-sort">Status</th>
                                            <th width="150" class="no-sort no-search text-center">Action</th>
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

    </div>
    @include('layouts.footer')
</div>

@if(auth()->user()->role_id == 4)
<!-- Complete Work Order Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="edit-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Maintenance Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Co-workers</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="co_workers[]" multiple>
                                @foreach($engineers as $engineer)
                                <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Status<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status">
                                <option value="not started">Not started</option>
                                <option value="in progress">In progress</option>
                                <option value="waiting for part">Waiting for part</option>
                                <option value="waiting for quotation">Waiting for quotation</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="inventory-section" style="display: none;">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Inventory</label>
                        <div class="col-sm-9">
                            <div class="row mb-2" id="inventory-form">
                                <div class="col-sm-7">
                                    <select class="form-control" alt="inventory_name"></select>
                                </div>
                                <div class="col-sm-3 pl-sm-0">
                                    <input type="number" class="form-control" min="0" alt="qty" placeholder="qty">
                                </div>
                                <div class="col-sm-2 pl-sm-0">
                                    <button type="button" class="btn btn-info btn-block"><i class="mdi mdi-plus font-weight-bold"></i></button>
                                </div>
                            </div>
                            <table class="table table-vertical" width="100%" id="inventory-datatable">
                                <thead>
                                    <tr class="font-weight-bold">
                                        <th>Name</th>
                                        <th width="100">Qty</th>
                                        <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" rows="8" style="resize: none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
