@extends('layouts.master')
@section('content')
<div class="content-page" id='account-page'>
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Account</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body datatable">
                            <div class="d-block text-right">
                                <a href="javascript: void(0)" class="btn btn-primary mb-3 add waves-effect waves-light">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create User
                                </a>
                            </div>
                            <table id="account-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th class="no-sort">Name</th>
                                    <th class="no-sort">Department</th>
                                    <th class="no-sort">Job Title</th>
                                    <th class="no-sort no-search">Contact</th>
                                    <th class="no-sort">Permission</th>
                                    <th width="180">Created</th>
                                    <th class="text-center no-sort">Action</th>
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
                    <h5 class="modal-title m-0">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="name" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Username<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="username" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="email" type="email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Password<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" required>
                                <div class="input-group-append waves-effect waves-dark">
                                    <span class="input-group-text">
                                        <a href="javascript: void(0)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="contact" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Department<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="department_id" class="form-control" required>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Job Title<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="job_id" class="form-control" required>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Permission<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="role_id" class="form-control" required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                    <h5 class="modal-title m-0">Edit User Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="name" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Username<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="username" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Email<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="email" type="email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input class="form-control" name="contact" type="text" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Department<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="department_id" class="form-control" required>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Job Title<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="job_id" class="form-control" required>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Permission<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="role_id" class="form-control" required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="reset-password-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">New Password<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" required>
                                <div class="input-group-append waves-effect waves-dark">
                                    <span class="input-group-text">
                                        <span href="javascript: void(0)">
                                            <i class="mdi mdi-eye-off"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Avatar Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <img src="#" class="img-fluid">
        </div>
    </div>
</div>
@endsection
