@extends('layouts.master')
@section('content')
<div class="content-page" id="equipment-page">

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Inventory</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="d-block text-right">
                                <a href="javascript: void(0)" class="btn btn-primary mb-3 add">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Item
                                </a>
                            </div>
                            <table id="equipment-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Model</th>
                                        <th class="no-sort">Manufacturer</th>
                                        <th class="no-sort">Description</th>
                                        <th class="no-sort">Location</th>
                                        <th class="no-sort">Maintenance Period</th>
                                        <th class="no-sort">Contact</th>
                                        <th width="100" class="no-search no-sort text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Add Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Serial Number<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="serial_number" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Model<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="equipment_model_id">
                                @foreach($equipment_models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Manufacturer<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="manufacturer" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" rows="8" class="form-control"></textarea>
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
                        <label for="example-text-input" class="col-sm-3 col-form-label">Maintenance Period<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input class="form-control" name="maintenance_period" min="0" type="number" autocomplete="off">
                        </div>
                        <div class="col-sm-4">
                            <label for="example-text-input" class="col-form-label">/ month</label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="contact" type="text" required autocomplete="off">
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Model<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="equipment_model_id">
                                @foreach($equipment_models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Manufacturer<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="manufacturer" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" rows="8" class="form-control"></textarea>
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
                        <label for="example-text-input" class="col-sm-3 col-form-label">Maintenance Period<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input class="form-control" name="maintenance_period" min="0" type="number" autocomplete="off">
                        </div>
                        <div class="col-sm-4">
                            <label for="example-text-input" class="col-form-label">/ month</label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="contact" type="text" required autocomplete="off">
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
@endsection
