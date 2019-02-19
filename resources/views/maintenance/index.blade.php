@extends('layouts.master')
@section('content')
<div class="content-page" id="maintenance-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Maintenance Schedule</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div id='maintenance-calendar'></div>

                            <div style='clear:both'></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @include('layouts.footer')
</div>
@endsection
