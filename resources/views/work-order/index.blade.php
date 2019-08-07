@extends('layouts.master')
@section('content')
<div class="content-page" id="work-order-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <div class="page-title-box">
                        <h4 class="page-title">My Work Order</h4>
                    </div>
                </div>
                @if(!in_array(auth()->user()->role_id, [1,2]))
                <div class="col d-inline d-sm-none text-right">
                    <div class="page-title-box ">
                        <a href="javascript: void(0)" class="btn btn-warning add-work-order">Create Work Order</a>
                    </div>
                </div>
                @endif
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-danger">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-calendar float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">Not Started</h6>
                                <h4 class="mb-4" id="not-started">{{ isset($data['not-started']) ? $data['not-started'] : 0 }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-primary">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-calendar-clock float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">In Progress</h6>
                                <h4 class="mb-4" id="in-progress">{{ isset($data['in-progress']) ? $data['in-progress'] : 0 }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-warning">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-calendar-multiple float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">Waiting</h6>
                                <h4 class="mb-4" id="waiting">{{ (isset($data['waiting-for-part']) ? $data['waiting-for-part'] : 0) + (isset($data['waiting-for-quotation']) ? $data['waiting-for-quotation'] : 0) }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-success">
                        <div class="card-body mini-stat-img">
                            <div class="mini-stat-icon">
                                <i class="mdi mdi-calendar-check float-right"></i>
                            </div>
                            <div class="text-white">
                                <h6 class="text-uppercase mb-3">Completed</h6>
                                <h4 class="mb-4" id="completed">{{ isset($data['completed']) ? $data['completed'] : 0 }}</h4>
                                <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vertical" id="work-order-datatable">

                                    <thead>
                                        <tr class="font-weight-bold">
                                            <th>Task</th>
                                            <th width="200" class="no-sort no-search">Location</th>
                                            <th width="150" class="no-sort no-search">Priority</th>
                                            <th width="150" class="no-sort">Status</th>
                                            <th width="190">Due Date</th>
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

@if(in_array(auth()->user()->role_id, [1,2,3]))
<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-record-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Create Work Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Task<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea name="task" rows="3" class="form-control" style="resize: none;" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Location<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="location_id">
                                @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->area }} - {{ $location->floor->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Deadline<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="due_date" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Priority<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="priority" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-9">
                            <img src="{{ asset('assets/images/default-photo.png') }}" class="image-preview" alt="image-preview">
                            <input type="file" class="mt-3" name="image" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(auth()->user()->role_id == 4)
<!-- Complete Work Order Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="edit-record-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Complete Work Order</h5>
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
                        <label for="example-text-input" class="col-sm-3 col-form-label">Comment</label>
                        <div class="col-sm-9">
                            <textarea name="comment" class="form-control" rows="8" style="resize: none;"></textarea>
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

<!-- Work Order Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center d-block">
                <h5 class="m-0"></h5>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Co-workers</label>
                    <div class="col-sm-9">
                        <strong class="form-control-plaintext" name="co_workers"></strong>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext">
                            <span class="badge badge-pills badge-success" name="status"></span>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Assignor</label>
                    <div class="col-sm-9">
                        <strong class="form-control-plaintext" name="assignor"></strong>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Location</label>
                    <div class="col-sm-9">
                        <strong class="form-control-plaintext" name="location"></strong>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Due Date</label>
                    <div class="col-sm-9">
                        <strong class="form-control-plaintext" name="due_date"></strong>
                    </div>
                </div>
                <div class="form-group row" id="inventory-section-detail">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Inventory</label>
                    <div class="col-sm-9">
                        <table class="table table-vertical" width="100%" id="inventory-datatable-detail">
                            <thead>
                                <tr class="font-weight-bold">
                                    <th>Name</th>
                                    <th width="100">Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-3 col-form-label">Comment</label>
                    <div class="col-sm-9">
                        <strong class="form-control-plaintext" name="comment">-</strong>
                    </div>
                </div>
                <div class="row" id="image-preview-detail">
                    <div class="col-sm-9 offset-sm-3">
                        <img src="assets/images/default-photo.png" class="image-preview">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Work Order Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <img src="#" class="img-fluid">
        </div>
    </div>
</div>
@endsection
