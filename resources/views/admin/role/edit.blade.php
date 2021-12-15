@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" :buttons="$buttons" icon="fa fa-edit"  type="default">
        @include("admin.alert")

        {!! Form::model($model, ['id' => 'form', 'class' => 'ajax', 'route' => ['admin.role.update',$model->id], 'method' => 'put']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('guard_name', trans("models.role.guard_name")); !!}
                    {!! Form::select('guard_name', $guards, null, ["class" => "form-control placeholder", "placeholder" => trans("models.common.select")]); !!}
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('name', trans("models.role.name")); !!}
                    {!! Form::text('name' , null, ["id" =>"name","class" => "form-control", "placeholder" => trans("models.role.name")]); !!}
                    <div class="invalid-feedback"></div>
                </div>

            </div>
        </div>

        {!! Form::close() !!}

    </x-card>

@endsection

@section("footerJS")
    <script>
        $(function(){


        });
    </script>
@endsection
