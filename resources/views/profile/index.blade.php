@extends('layouts.master')
@section('content')
<div class="content-page" id="profile-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://images.unsplash.com/photo-1549630755-15b113e34179?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=300&h=300&q=80" class="full-profile rounded" alt="profile">
                                </div>
                                <div class="col-md-9 bg-light">
                                    <form action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Co-workers</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @include('layouts.footer')
</div>
@endsection
