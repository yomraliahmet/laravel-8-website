@extends(config("admin.layout"))

@section("title", $title)

@section("content")


    <x-card :title="$title" icon="fa fa-edit"  type="default">
        @include("admin.alert")
        <div class="row">

            <div class="col-md-2">
                <img class="preview" width="100%" height="auto" src="{{ $model->image->url }}" alt="">
                <label class="btn btn-default btn-file btn-block">
                    <i class="fa fa-camera"></i> {{ trans("models.profile.browse") }} <input onchange="readURLLocal(this)" id="form" type="file" name="image" style="display: none;">
                </label>
            </div>
            <div class="col-md-10">
                <div class="createForm">
                    {!! Form::model($model,['id' => 'form', 'class' => 'ajax', 'route' => ['admin.profile.update',$model->id], 'method' => 'put']) !!}
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('name', trans("models.profile.name")); !!}
                                {!! Form::text('name', null, ["class" => "form-control", "placeholder" => trans("models.profile.name")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('email', trans("models.profile.email")); !!}
                                {!! Form::email('email', null, ["class" => "form-control", "placeholder" => trans("models.profile.email")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('password', trans("models.profile.password")); !!}
                                {!! Form::password('password', ["class" => "form-control", "placeholder" => trans("models.profile.password")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-md">{{ trans("admin.common.update") }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </x-card>
@endsection

@section("footerJS")
<script>
    function readURLLocal(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(".preview").attr('src', e.target.result);
                $(".profile").attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
