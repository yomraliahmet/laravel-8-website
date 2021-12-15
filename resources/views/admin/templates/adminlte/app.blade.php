<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title", config("app.name"))</title>

    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ $templateUrl }}/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



    @yield("cssFile")

    <link rel="stylesheet" href="{{ asset("assets/backend/css/custom.css") }}">

    @yield("css")

    <script defer src="{{ asset("assets/js/translation.js") }}" type="text/javascript"></script>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <form class="form-inline ml-3" onsubmit="return false;">
            <div class="input-group input-group-sm">
                <input id="filterinput" class="form-control form-control-navbar" type="search" placeholder="{{ trans("admin.common.search") }}" aria-label="{{ trans("admin.common.search") }}">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                   <!-- <i class="fa fa-user-circle fa-2x"></i> -->
                    <img width="32" height="30" src="{{ auth()->guard("admin")->user()->image->url ??  url("backend/assets/images/user.png") }}" class="profile img-circle img-size-32 mr-2">
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img width="50" height="48" src="{{ auth()->guard("admin")->user()->image->url ??  url("backend/assets/images/user.png") }}" alt="{{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}" class="profile img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h4 class=" mt-2 ">
                                    {{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}
                                </h4>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route("admin.profile.edit", auth()->guard("admin")->id()) }}" class="dropdown-item"><i class="fa fa-user-edit mr-1"></i> {{ trans("admin.common.profile") }}</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item dropdown-footer bg-danger"><i class="fas fa-sign-out-alt mr-1"></i> {{ trans("admin.common.logout") }}</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route("admin.home.index") }}" class="brand-link">
            <!--
            <img width="32" height="30" src="{{ auth()->guard("admin")->user()->image->url ??  url("backend/assets/images/user.png") }}" alt="{{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
                 -->
                <i class="far fa-building ml-3 mr-2" style="font-size: 24px;"></i>
            <span class="brand-text font-weight-light font-weight-bold">{{ trans("admin.common.title") }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul id="list" role="list" class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route("admin.home.index") }}" class="nav-link {{ request()->route()->getAction("as") == "admin.home.index" ? "active" : "" }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>{{ trans("admin.sidebar.dashboard") }}</p>
                        </a>
                    </li>

                    {{ \App\Helpers\Menu::render() }}
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid pt-3">
                @yield("content")
                <br>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; <span id="copy-year">2020</span></strong>
        <script>
            var d = new Date();
            var year = d.getFullYear();
            document.getElementById("copy-year").innerHTML = year;
        </script>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset("assets/backend") }}/plugins/jquery/jquery.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset("assets/backend") }}/plugins/bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>

<script src="{{ asset("assets/backend") }}/plugins/select2/js/select2.full.js" type="text/javascript"></script>
<script src="{{ asset("assets/backend") }}/plugins/select2/js/i18n/{{ app()->getLocale() }}.js" type="text/javascript"></script>

<!-- AdminLTE -->
<script defer src="{{ $templateUrl }}/dist/js/adminlte.js" type="text/javascript"></script>

<script defer src="{{ $templateUrl }}/assets/js/sidebar.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script defer src="{{ asset('vendor/translation/js/app.js') }}" type="text/javascript"></script>
<script defer src="{{ asset("assets/backend/js/laravel.js") }}" type="text/javascript"></script>
<script defer src="{{ asset("assets/backend/js/form.js") }}" type="text/javascript"></script>

<script defer src="{{ asset("assets/js/custom.js") }}" type="text/javascript"></script>

@yield("footerJSFile")
@yield("footerJS")
</body>
</html>
