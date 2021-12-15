<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr" data-dir="{{ config("admin.template_dir") }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ trans('admin.common.title') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title", config("app.name"))</title>

    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500&display=swap" rel="stylesheet" />
    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- PLUGINS CSS STYLE -->
    <link href="{{ $templateUrl }}/plugins/nprogress/nprogress.css" rel="stylesheet" />

    <!-- No Extra plugin used -->
    <link href="{{ $templateUrl }}/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="{{ $templateUrl }}/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="{{ $templateUrl }}/plugins/toastr/toastr.min.css" rel="stylesheet" />

    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="{{ $templateUrl }}/css/sleek.css" />
    <link rel="stylesheet" href="{{ $templateUrl }}/css/custom.css" />

    @yield("cssFile")
    <link rel="stylesheet" href="{{ url("assets/backend/css/custom.css") }}">
    @yield("css")

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
</head>


<body class="header-fixed sidebar-fixed sidebar-dark header-light right-sidebar-toggoler-out compact-spacing sidebar-mobile-out" id="body">

<script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
</script>

<!--
<div id="toaster"></div>
-->

<div class="wrapper">

    <aside class="left-sidebar bg-sidebar">
        <div id="sidebar" class="sidebar">
            <!-- Aplication Brand -->
            <div class="app-brand">
                <a href="{{ route("admin.home.index") }}" title="{{ trans('admin.common.title') }}">
                    <svg
                        class="brand-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="xMidYMid"
                        width="30"
                        height="33"
                        viewBox="0 0 30 33"
                    >
                        <g fill="none" fill-rule="evenodd">
                            <path
                                class="logo-fill-blue"
                                fill="#7DBCFF"
                                d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                            />
                            <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                        </g>
                    </svg>
                    <span class="brand-name text-truncate">{{ trans("admin.common.title") }}</span>
                </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">

                <!-- sidebar menu -->
                <ul class="nav sidebar-inner sidebarList nav-sidebar" id="sidebar-menu">

                    <li  class="{{ request()->route()->getAction("as") == "admin.home.index" ? "active" : "" }}" >
                        <a class="sidenav-item-link" href="{{ route("admin.home.index") }}">
                            <i class="fa fa-home"></i>
                            <span class="nav-text">{{ trans("admin.sidebar.dashboard") }}</span>
                        </a>
                    </li>

                    {{ \App\Helpers\Menu::render() }}

                </ul>

            </div>

        </div>
    </aside>


    <div class="page-wrapper">
        <!-- Header -->
        <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg pr-0">
                <!-- Sidebar toggle button -->
                <button id="sidebar-toggler" class="sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <!-- search form -->
                <div class="search-form d-none d-lg-inline-block">
                    <div class="input-group">

                        <button form="searchFrom" type="button" name="search" id="search-btn" class="btn btn-flat">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <form id="searchFrom" onsubmit="return false;">
                        <input type="text" name="query" id="filterinput" class="form-control" placeholder="{{ trans("admin.common.search") }}"
                               autofocus autocomplete="off" />
                        </form>
                    </div>
                </div>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">

                        <!-- User Account -->
                        <li class="dropdown user-menu">
                            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <img src="{{ auth()->guard("admin")->user()->image->url ??  url("assets/backend/images/user.png") }}" class="profile user-image" alt="{{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}" width="40px" height="38px" />
                                <span class="d-none d-lg-inline-block">{{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <!-- User image -->
                                <li class="dropdown-header">
                                    <img src="{{ auth()->guard("admin")->user()->image->url ??  url("assets/backend/images/user.png") }}" class="profile img-circle" alt="{{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }}" width="50px" height="48px" />
                                    <div class="d-inline-block">
                                        {{ auth()->guard("admin")->user()->name ?? trans("admin.common.admin_name") }} <small class="pt-1">{{ auth()->guard("admin")->user()->email ?? "" }}</small>
                                    </div>
                                </li>

                                <li>
                                    <a href="{{ route("admin.profile.edit", auth()->guard("admin")->id()) }}">
                                        <i class="mdi mdi-account"></i> {{ trans("admin.common.profile") }}
                                    </a>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="{{ route("admin.logout") }}"> <i class="mdi mdi-logout"></i> {{ trans("admin.common.logout") }} </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>


        </header>


        <div class="content-wrapper">
            <div class="content p-2">
                @yield("content")
            </div>
        </div>

        <footer class="footer mt-auto">
            <div class="copyright bg-white">
                <p>
                    Copyright &copy; <span id="copy-year">2020</span>
                </p>
            </div>
            <script>
                var d = new Date();
                var year = d.getFullYear();
                document.getElementById("copy-year").innerHTML = year;
            </script>
        </footer>

    </div>
</div>

<script src="{{ $templateUrl }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ $templateUrl }}/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
<!--
<script src="{{ $templateUrl }}/plugins/jekyll-search.min.js"></script>
-->

<script src="{{ $templateUrl }}/plugins/charts/Chart.min.js"></script>
<script src="{{ $templateUrl }}/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="{{ $templateUrl }}/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
<script src="{{ $templateUrl }}/plugins/daterangepicker/moment.min.js"></script>
<script src="{{ $templateUrl }}/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('input[name="dateRange"]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
            jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
        });
        jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
            jQuery(this).val('');
        });
    });
</script>

<script src="{{ asset("assets/backend") }}/plugins/select2/js/select2.full.js" type="text/javascript"></script>
<script src="{{ asset("assets/backend") }}/plugins/select2/js/i18n/{{ app()->getLocale() }}.js" type="text/javascript"></script>

<script src="{{ $templateUrl }}/plugins/toastr/toastr.min.js"></script>
<script src="{{ $templateUrl }}/js/sleek.bundle.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ url("assets/backend/js/sidebar.js") }}" type="text/javascript"></script>

<script src="{{ asset('/vendor/translation/js/app.js') }}" type="text/javascript"></script>
<script src="{{ url("assets/backend/js/laravel.js") }}" type="text/javascript"></script>
<script defer src="{{ url("assets/backend/js/form.js") }}" type="text/javascript"></script>

<script src="{{ url("/assets/js/custom.js") }}" type="text/javascript"></script>

@yield("footerJSFile")
@yield("footerJS")
</body>
</html>
