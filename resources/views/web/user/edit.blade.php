@extends("web.layout")

@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">{{ trans("web.common.my_account") }}</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url("/") }}">{{ trans("web.common.home") }}</a></li>
                        <li class="active">{{ trans("web.common.my_account") }}</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-6">

                    <div class="panel panel-default">
                        <h4 class="panel-heading">{{ trans('web.register.label') }}</h4>
                        <div class="panel-body">

                            {!! Form::open(['route' => 'web.register', 'id' => 'register-form', 'onsubmit' => 'return false;']) !!}
                            <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    {!! Form::text('fullname', null, ['class' => 'form-control', 'placeholder' => trans('web.register.fullname'), 'autocomplate' => 'off']) !!}
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('web.register.email'), 'autocomplate' => 'off']) !!}
                                </div>
                                <div class="form-group col-md-12 ">
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('web.register.password')]) !!}
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-2">
                                        {{ trans("web.register.label")  }}
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div id="alert-content"></div>

                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <h4 class="panel-heading">{{ trans("web.login.label")  }}</h4>
                        <div class="panel-body">

                            {!! Form::open(['route' => 'web.login', 'id' => 'login-form', 'onsubmit' => 'return false;']) !!}
                            <div class="row">
                                <div class="form-group col-md-12 mb-4">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('web.login.email'), 'autocomplate' => 'off', 'required']) !!}
                                </div>
                                <div class="form-group col-md-12 ">
                                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('web.login.password'), 'required']) !!}
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-lg btn-success btn-block mb-2">
                                        {{ trans("web.login.label")  }}
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div id="alert-content"></div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

@endsection

@section('footerJS')
<script>

    // LOGIN
    $("#login-form").submit(function(){
        var url = $(this).attr("action");
        var data = $('#login-form').serialize();
        var post = $.post(url,data);

        post.done(function(data){
            if(data.url){
                window.location = data.url;
            }
        });

        post.fail(function(jqXHR, textStatus, errorThrown){
            var status_message = "";
            if([400,403].includes(jqXHR.status)){
                status_message = jqXHR.responseJSON.message;
            }

            else if(jqXHR.status === 0){
                status_message = trans('messages.common.connection_refused');
            }
            else{
                status_message = errorThrown;
                if(status_message === ""){
                    status_message = trans('messages.common.global_error');
                }
            }
            var alert = '<div class="alert alert-danger" style="margin-top:10px;">'+status_message+'</div>';
            $("#alert-content").html(alert);
            setTimeout(function(){
                $(".alert").hide(300);
            },2000);
        });
    });


    // LOGIN
    $("#register-form").submit(function(){
        var url = $(this).attr("action");
        var data = $('#register-form').serialize();
        var post = $.post(url,data);

        post.done(function(data){
            if(data.url){
                window.location = data.url;
            }
        });

        post.fail(function(jqXHR, textStatus, errorThrown){
            var status_message = "";
            if([400,403].includes(jqXHR.status)){
                status_message = jqXHR.responseJSON.message;
            }

            else if(jqXHR.status === 0){
                status_message = trans('messages.common.connection_refused');
            }
            else{
                status_message = errorThrown;
                if(status_message === ""){
                    status_message = trans('messages.common.global_error');
                }
            }
            var alert = '<div class="alert alert-danger" style="margin-top:10px;">'+status_message+'</div>';
            $("#alert-content").html(alert);
            setTimeout(function(){
                $(".alert").hide(300);
            },2000);
        });
    });


</script>
@endsection
