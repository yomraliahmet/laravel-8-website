@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" :buttons="$buttons" icon="fa fa-edit"  type="default">
        @include("admin.alert")
        <div class="row">

            <div class="col-md-2">
                <img class="preview" width="100%" height="auto" src="{{ $model->image->url ?? url("/assets/backend/images/noimage.png") }}" alt="">
                <label class="btn btn-default btn-file btn-block">
                    <i class="fa fa-camera"></i> {{ trans("models.profile.browse") }} <input onchange="readURLLocal(this)" form="form" type="file" name="image" style="display: none;">
                </label>
            </div>
            <div class="col-md-10">
                <div class="createForm">
                    {!! Form::model($model,['id' => 'form', 'class' => 'ajax', 'route' => ['admin.admin.update',$model->id], 'method' => 'put']) !!}
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('name', trans("models.admin.name")); !!}
                                {!! Form::text('name', null, ["class" => "form-control", "placeholder" => trans("models.profile.name")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('email', trans("models.admin.email")); !!}
                                {!! Form::email('email', null, ["class" => "form-control", "placeholder" => trans("models.profile.email")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('password', trans("models.admin.password")); !!}
                                {!! Form::password('password', ["class" => "form-control", "placeholder" => trans("models.profile.password")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('roles', trans("models.admin.roles")); !!}
                                {!! Form::select('roles[]',$roles,$model->getRoleNames(), ["id" => "roles","class" => "form-control select2", "multiple" => "multiple"]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </x-card>
@endsection

@section("css")
<style>
    .select2-container{
        width: 100%!important;
    }
    .select2-search--dropdown .select2-search__field {
        width: 98%;
    }
</style>
@endsection

@section("footerJS")
<script>
    function readURLLocal(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(".preview").attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('select#roles').select2({
            placeholder: '{{ trans("models.common.select") }}',
        });
    });
</script>
@endsection
