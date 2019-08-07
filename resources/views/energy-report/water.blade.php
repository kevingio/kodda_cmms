@include('energy-report.filter')
<table class="table table-bordered" id="water-datatable" style="width: 100%;">
    <thead>
        <tr>
            <th>Day</th>
            <th>PDAM</th>
            <th>PDAM Consumption</th>
            <th>PDAM Cost</th>
            <th>PDAM Month to Date</th>
            <th>Deep Well</th>
            <th>Deep Well Consumption</th>
            <th>Deep Well Total</th>
            <th>Occupancy</th>
            <th>Water per Room</th>
            @if(in_array(auth()->user()->role_id, [1,2]))
            <th class="no-sort no-search text-center">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Edit Modal -->
<div class="modal fade" id="editWaterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="edit-water-record-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Edit Water Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">PDAM<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="pdam" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Deep Well<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="deep_well" type="text" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Occupancy<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="occupancy" type="text" required autocomplete="off">
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
