<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Integrated Resource Management by Jetech</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div class="wrapper-page px-3">

            <div class="card">
                <div class="card-body">

                    <h3 class="text-center m-0">
                        <a href="{{ route('home') }}" class="logo logo-admin"><img src="{{ asset('assets/images/logo.png') }}" height="30" alt="logo"></a>
                    </h3>

                    <div class="p-3">
                        <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
                        <p class="text-muted text-center">Sign in to continue to IRM.</p>
                        @if($errors->any())
                            <p class="text-danger m-0">Username or password is incorrect!</p>
                        @endif

                        <form class="form-horizontal m-t-30" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" oninput="this.value=this.value.toLowerCase()" placeholder="Enter username" required>
                            </div>

                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password" required>
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p>© 2019 IRM. Crafted with <i class="mdi mdi-heart text-danger"></i> by Jet Technology</p>
            </div>

        </div>

        <script src="{{ mix('js/app.js') }}"></script>

    </body>
</html>
