@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" icon="fa fa-edit"  type="default">
        @include("admin.alert")
        <div class="row">
            <div class="col-md-12">
                <div class="createForm">
                    {!! Form::model($model,['id' => 'form', 'class' => 'ajax', 'route' => ['admin.setting.update'], 'method' => 'put']) !!}
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('currency', trans("models.setting.currency")); !!}
                                {!! Form::select('currency', \App\Models\Setting::CURRENCIES , null, ["class" => "form-control placeholder", "placeholder" => trans("models.common.select")]); !!}
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

