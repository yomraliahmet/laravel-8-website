<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('admin.login.title') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ $templateUrl }}/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script defer src="{{ asset("assets/js/translation.js") }}" type="text/javascript"></script>
    <script defer src="{{ asset("assets/js/custom.js") }}" type="text/javascript"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{ trans('admin.login.title') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('admin.login.message') }}</p>

            {!! Form::open(['route' => 'admin.login', 'id' => 'login-form', 'data-redirect' => route('admin.home.index'), 'action' => url('admin/login'), 'onsubmit' => 'return false;']) !!}
                <div class="input-group mb-3">
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('admin.login.email'), 'autocomplate' => 'off', 'required']) !!}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('admin.login.password'), 'required']) !!}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <span id="spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                            {{ trans("admin.login.sign_in")  }}
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
            <div id="alert-content"></div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset("assets/backend") }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("assets/backend") }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ $templateUrl }}/dist/js/adminlte.min.js"></script>
<!-- Log In -->
<script src="{{ $templateUrl }}/assets/js/login.js"></script>

<script>
    $(function(){
        $("input[name=email]").val("{{ $admin["email"] ?? null }}");
        $("input[name=password]").val("{{ $admin["password"] ?? null }}");
    });
</script>

</body>
</html>
