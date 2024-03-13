<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KVN | {{__('msg.loginTitle')}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="min-height: auto;">
    @if(session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    @elseif($errors->has('error'))
    <div class="alert alert-danger" id="success-alert">
        {{ $errors->first('error') }}
    </div>
    @endif
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1 ">KATSURA<b> VN</b></a>
            </div>
            <div class="card-body">
                <h4 class="login-box-msg text-primary">{{__('msg.loginTitle')}}</h4>
                <form action="{{route('login-account')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input class="form-control" placeholder="{{__('msg.loginEmail')}}" name="email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span class="text-danger">@error('email') {{$message}}@enderror</span>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="{{__('msg.loginPassword')}}" name="password" value="{{ old('password') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="text-danger">@error('password') {{$message}}@enderror</span>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    {{__('msg.savePassword')}}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block">{{__('msg.loginTitle')}}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="#" class="text-center text-sm">{{__('msg.requestResetPassword')}}</a>
                </p>
                <p class="mb-0">
                    <a href="/contact" class="text-center text-sm">{{__('msg.contactSupport')}}</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>