@extends('layouts.master')
@section('content')
<div class="content-page" id="work-report-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Submit Daily Report</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <form id="add-record-form">
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-md-2 col-form-label">Work Date</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control disabled" value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Work Order</label>
                                    <div class="col-sm-10">
                                        <table class="table table-bordered dt-responsive nowrap">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th width="150">WO Number</th>
                                                    <th>Task</th>
                                                    <th width="200" class="no-sort no-search">Location</th>
                                                    <th width="200" class="no-sort no-search">Assignor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($work_orders as $wo)
                                                <tr>
                                                    <td>{{ $wo->wo_number }}</td>
                                                    <td>{{ $wo->task }}</td>
                                                    <td>{{ $wo->location->area }} - {{ $wo->location->floor->description }}</td>
                                                    <td>{{ $wo->assignor->name }}</td>
                                                </tr>
                                                @endforeach
                                                @if(count($work_orders) == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No data available in table</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Maintenace</label>
                                    <div class="col-sm-10">
                                        <table class="table table-bordered dt-responsive nowrap">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th width="150">MT Number</th>
                                                    <th>Model</th>
                                                    <th>Serial Number</th>
                                                    <th width="200" class="no-sort no-search">Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($maintenances as $mt)
                                                <tr>
                                                    <td>{{ $mt->mt_number }}</td>
                                                    <td>{{ $mt->equipment_model->name }}</td>
                                                    <td>{{ $mt->equipment->serial_number }}</td>
                                                    <td>{{ $mt->equipment->location->area }} - {{ $mt->equipment->location->floor->description }}</td>
                                                </tr>
                                                @endforeach
                                                @if(count($maintenances) == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">No data available in table</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Activity</label>
                                    <div class="col-sm-10">
                                        <textarea name="activity" class="form-control" rows="5" style="resize: none;" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <a href="window.history.back()" class="btn btn-dark mr-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('layouts.footer')

</div>
@endsection
