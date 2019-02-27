@include('energy-report.filter')
<table class="table table-bordered" id="gas-datatable" style="width: 100%;">
    <thead>
        <tr>
            <th>Day</th>
            <th>Gas</th>
            <th>Comsumption</th>
            <th>Cost</th>
            <th>Gas Month to Date</th>
            @if(in_array(auth()->user()->role_id, [1,2]))
            <th class="no-sort no-search text-center">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Edit Modal -->
<div class="modal fade" id="editGasModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-gas-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Edit Gas Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">LPG/CNG<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="lpg" type="text" required autocomplete="off">
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
