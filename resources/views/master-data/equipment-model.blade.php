@extends('layouts.master')
@section('content')
<div class="content-page" id="masterdata-equipment-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Equipment Model List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="d-block text-right">
                                <a href="javascript: void(0)" class="btn btn-primary mb-3 add-model waves-effect waves-light">Add Record</a>
                            </div>
                            <table id="equipment-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Equipment Model</th>
                                        <th width="150" class="text-center no-sort no-search">Action</th>
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
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Maintenance Task List</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="d-block text-right">
                                <a href="javascript: void(0)" class="btn btn-primary mb-3 add-maintenance waves-effect waves-light">Add Record</a>
                            </div>
                            <table id="maintenance-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th width="200">Inventory Model</th>
                                        <th width="150" class="text-center no-sort no-search">Action</th>
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

<!-- Add Model Modal -->
<div class="modal fade" id="addModelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="add-model-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Add Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Model Name<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" autocomplete="off" required>
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

<!-- Edit Model Modal -->
<div class="modal fade" id="editModelModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="edit-model-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Model Name<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" autocomplete="off" required>
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

<!-- Add Maintenance Task Modal -->
<div class="modal fade" id="addMaintenanceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-maintenance-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Add Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Task<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea name="task" rows="8" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Equipment Model<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="equipment_model_id" required>
                                @foreach($equipment_models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
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

<!-- Edit Maintenance Task Modal -->
<div class="modal fade" id="editMaintenanceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-maintenance-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Edit Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Task<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea name="task" rows="8" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Equipment Model<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="equipment_model_id" required>
                                @foreach($equipment_models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
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
