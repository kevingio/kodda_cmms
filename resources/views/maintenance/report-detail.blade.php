@extends('layouts.master')
@section('content')
<div class="content-page" id="maintenance-report-detail-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Maintenance Report #{{ $mt_report->mt_number }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="index.html" method="post">
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Inventory Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" value="{{ $mt_report->inventory->name }}" readonly>
                                    </div>
                                    <label for="example-url-input" class="col-sm-2 col-form-label offset-sm-2">Inventory Model</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" value="{{ $mt_report->inventory->inventory_model->name }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Person in Charge</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="pic" required>
                                    </div>
                                    <label for="example-text-input" class="col-sm-2 col-form-label offset-sm-2">Location</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" value="{{ $mt_report->inventory->location->area }} - {{ $mt_report->inventory->location->floor->description }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Tasks</label>
                                    <div class="col-10">
                                        @foreach($mt_report->inventory->inventory_model->maintenance_tasks as $task)
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="{{ $task->id }}">{{ $task->task }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-url-input" class="col-sm-2 col-form-label">Activity</label>
                                    <div class="col-sm-10">
                                        <textarea name="activity" class="form-control" rows="8" style="resize: none;" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 offset-md-2">
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
