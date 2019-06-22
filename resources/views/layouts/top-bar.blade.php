<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{ route('home') }}" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="18">
            </span>
            <i>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </i>
        </a>
    </div>

    <nav class="navbar-custom">

        <ul class="navbar-right d-flex list-inline float-right mb-0">

            <!-- <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-pill badge-danger noti-icon-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                    <h6 class="dropdown-item-text">
                        Notifications (258)
                    </h6>
                    <div class="slimscroll notification-item-list">
                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                            <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                            <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-warning"><i class="mdi mdi-message"></i></div>
                            <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-info"><i class="mdi mdi-martini"></i></div>
                            <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                            <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-danger"><i class="mdi mdi-message"></i></div>
                            <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                        </a>
                    </div>
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li> -->
            <li class="dropdown notification-list">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="mr-2" id="profile-name">{{ auth()->user()->name }}</span>
                        <img src="{{ !empty(auth()->user()->avatar) ? auth()->user()->avatar : asset('assets/images/users/user-4.jpg') }}" alt="user" id="profile-picture" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <a class="dropdown-item" href="javascript: void(0)" data-toggle="modal" data-target="#profileModal"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                        <a class="dropdown-item" href="javascript: void(0)" data-toggle="modal" data-target="#changePasswordModal"><i class="mdi mdi-lock-open-outline m-r-5"></i> Change Password</a>
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-power text-danger"></i> Logout
                        </a>
                    </div>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>

            <li class="d-none d-sm-block">
                @if(!request()->is('work-report/*') && in_array(auth()->user()->role_id, [2,4,5,6]))
                <div class="dropdown pt-3 d-inline-block">
                    <a class="btn btn-primary" href="{{ route('work-report.create') }}">
                        Add Daily Activity
                    </a>
                </div>
                @endif

                @if(in_array(auth()->user()->role_id, [3]))
                <div class="dropdown ml-3 pt-3 d-inline-block">
                    <a class="btn btn-warning add-work-order" href="javascript: void(0)">
                        Create Work Order
                    </a>
                </div>
                @endif
            </li>


        </ul>

    </nav>

</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="update-profile-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title m-0">My Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="contact" value="{{ auth()->user()->contact }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-9">
                            <img src="{{ asset(!empty(auth()->user()->avatar) ? auth()->user()->avatar : 'assets/images/default-photo.png') }}" class="image-preview" alt="image-preview">
                            <input type="file" class="mt-3" name="avatar" accept="image/*">
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

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="change-password-form">
                <div class="modal-header">
                    <h5 class="modal-title m-0">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-3 col-form-label">Old Password<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="password" name="old_password" class="form-control" required>
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
                    <input type="hidden" name="sls" value="{{ encrypt(auth()->user()->id) }}" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
