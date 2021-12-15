@extends(config('admin.layout'))

@section("title", $title)

@section("content")
    <div class="row">

        <div class="col-md-6 order-md-2">
            <x-card :title="$edittitle" :buttons="$buttons" icon="fa fa-edit"  type="default">
                <div class="createForm">
                    {!! Form::model($model,['id' => 'form', 'class' => 'ajax reset', 'route' => ['admin.menu.update',$model->id], 'method' => 'put']) !!}

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach(config("translatable.locales") as $key => $locale)
                                <li class="nav-item position-relative">
                                    <a class="nav-link {{ $key == 0 ? 'active': '' }}" id="{{ $locale }}-tab" data-toggle="tab" href="#{{ $locale }}" role="tab" aria-controls="{{ $locale }}" aria-selected="true">
                                        {{ strtoupper($locale) }}
                                        <i class="fas fa-exclamation-circle text-danger tab-warning tab-warning-{{ $locale }} text-hide position-absolute" style="top:3px;right: 3px;"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-2" id="myTabContent">
                            @foreach(config("translatable.locales") as $key => $locale)
                                <div class="tab-pane fade show {{ $key == 0 ? 'active': '' }}" id="{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {!! Form::label('name', trans("models.menu.name")); !!}
                                            {!! Form::text($locale.'[name]' , $model->translate($locale)->name , ["id" => $locale."_name","class" => "form-control", "placeholder" => trans("models.menu.name")]); !!}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('permission', trans("models.menu.permission")); !!}
                                {!! Form::text('permission', null, ["class" => "form-control placeholder", "placeholder" => trans("models.common.select"), "list" => "permissions"]); !!}
                                <div class="invalid-feedback"></div>
                                <datalist id="permissions">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('route', trans("models.menu.route")); !!}
                                {!! Form::text('route', null, ["class" => "form-control", "placeholder" => trans("models.common.select"), "list" => "routes"]); !!}
                                <div class="invalid-feedback"></div>
                                <datalist id="routes">
                                    @foreach($routes as $route)
                                    <option value="{{ $route }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('url', trans("models.menu.url")); !!}
                                {!! Form::text('url', null, ["class" => "form-control", "placeholder" => trans("models.menu.url")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('icon', trans("models.menu.icon")); !!}

                                <div class="input-group">
                                    {!! Form::text('icon', null, ["class" => "form-control", "placeholder" => trans("models.menu.icon")]); !!}
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary" data-icon="fas fa-home" role="iconpicker"></button>
                                    </span>
                                </div>

                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('target', trans("models.menu.target")); !!}
                                {!! Form::select('target',["_blank" => "_blank","_self" => "_self", "_parent" => "_parent", "_top" => "_top"], null, ["class" => "form-control placeholder", "placeholder" => trans("models.common.select")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('status', trans("models.menu.status")); !!}
                                <div class="custom-control custom-switch custom-switch-md custom-switch-off-danger custom-switch-on-success">
                                    {!! Form::checkbox('is_active', 1, true,["id" => "status","class" => "custom-control-input"]); !!}
                                    <label class="custom-control-label" for="status"></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </x-card>
        </div>

        <div class="col-md-6 order-md-1">
            <x-card :title="$title" icon="fa fa-list" type="default">
                {!! $menu !!}
            </x-card>
        </div>

    </div>
@endsection

@section("css")
   <style>
       .placeholder{color: grey;}
       select option:first-child{color: grey; display: block;}
       select option{color: #555;}

       .dropdown-toggle::after {
           display: none;
       }

   </style>
@endsection

@section("cssFile")
    <link rel="stylesheet" href="{{ url('/assets/backend/css/nestable.css') }}">
    <link rel="stylesheet" href="{{ url('assets/backend/plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}">
@endsection

@section("footerJSFile")
    <script src="{{ url('/assets/backend/js/nestable.js') }}"></script>

    <script src="{{ url('/assets/backend/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endsection

@section("footerJS")
    <script>
        $(function (){

            $('button.iconpicker').on('change', function(e) {
                $("#icon").val(e.icon);
            });

            $('select').change(function() {
                if ($(this).children('option:first-child').is(':selected')) {
                    $(this).addClass('placeholder');
                } else {
                    $(this).removeClass('placeholder');
                }
            });
        });


        function nestableAjax(e){
            var list   = e.length ? e : $(e.target);
            var output = window.JSON.stringify(list.nestable('serialize'));
            if (window.JSON) {
                $.ajax({
                    url: '{{ route("admin.menu.nestable") }}',
                    type: 'post',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function (data) {
                        if(data.code === "success"){
                            $("ul.nav-sidebar li:not(:first)").remove();
                            $("ul.nav-sidebar li:first").after(data.data).show(500);
                        }
                    },
                    error: function(data){
                        if(data.responseJSON.code === "error"){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.responseJSON.message,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    },
                    data: output
                });

            } else {
                console.log("Not working!.");
            }
        }

        $('.dd').nestable({ group: 1, maxDepth: 3})
            .on('change', function(e) {
                nestableAjax(e);
            });

        $( document ).ajaxComplete(function( event, xhr, settings ) {

            if(xhr.readyState === 4 && xhr.responseJSON.hasOwnProperty('data')){

                if(xhr.responseJSON.data.hasOwnProperty('nestable')){
                    $("#nestable").parent().html(xhr.responseJSON.data.nestable);

                    $('.dd').nestable({ group: 1, maxDepth: 3})
                        .on('change', function(e) {
                            nestableAjax(e);
                        }).trigger("change");
                }

            }
            if(xhr.readyState === 4 && xhr.responseJSON.hasOwnProperty('url')){
                window.location = xhr.responseJSON.url;
            }
        });

    </script>
@endsection
