<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ trans('admin.login.title') }}</title>

        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

        <!-- SLEEK CSS -->
        <link href="https://unpkg.com/sleek-dashboard/dist/assets/css/sleek.min.css" rel="stylesheet">

        <!-- FAVICON -->
        <link href="{{ url('/') }}/favicon.ico" rel="shortcut icon" />

        <!--
          HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
        -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="{{ $templateUrl }}/plugins/nprogress/nprogress.js"></script>

        <script src="{{ url("/assets/js/translation.js") }}" type="text/javascript"></script>
        <script src="{{ url("/assets/js/custom.js") }}" type="text/javascript"></script>
    </head>

</head>
<body class="bg-light-gray" id="body">
<div class="container d-flex flex-column justify-content-between">
    <div class="row justify-content-center mt-100">
        <div class="col-xl-5 col-lg-6 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="app-brand">
                        <a href="#">
                            <i class="fas fa-sign-in-alt" style="font-size: 36px; color: white;"></i>
                            <span class="brand-name" style="font-size: 22px; color: white;">{{ trans('admin.login.title') }}</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">

                    <h4 class="text-dark mb-4">{{ trans("admin.login.sign_in")  }}</h4>
                    {!! Form::open(['route' => 'admin.login', 'id' => 'login-form', 'onsubmit' => 'return false;']) !!}
                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('admin.login.email'), 'autocomplate' => 'off', 'required']) !!}
                            </div>
                            <div class="form-group col-md-12 ">
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('admin.login.password'), 'required']) !!}
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-primary btn-block mb-2">
                                    <span id="spinner" class="spinner-border spinner-border-md" role="status" aria-hidden="true" style="display: none; position: absolute;margin-top: -4px;"></span>
                                    {{ trans("admin.login.sign_in")  }}
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <div id="alert-content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="{{ url("assets/backend/js/login.js") }}"></script>

<script>
    $(function(){
        $("input[name=email]").val("{{ $admin["email"] ?? null }}");
        $("input[name=password]").val("{{ $admin["password"] ?? null }}");
    });
</script>

</body>
</html>
