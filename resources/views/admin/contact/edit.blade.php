@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" icon="fa fa-edit"  type="default">
        @include("admin.alert")
        <div class="row">
            <div class="col-md-12">
                <div class="createForm">
                    {!! Form::model($model,['id' => 'form', 'class' => 'ajax', 'route' => ['admin.contact.update'], 'method' => 'put']) !!}
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('phone', trans("models.contact.phone")); !!}
                                {!! Form::text('phone', null, ["class" => "form-control", "placeholder" => trans("models.contact.phone")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('email', trans("models.contact.email")); !!}
                                {!! Form::text('email', null, ["class" => "form-control", "placeholder" => trans("models.contact.email")]); !!}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('address', trans("models.contact.address")); !!}
                                {!! Form::text('address', null, ["class" => "form-control", "placeholder" => trans("models.contact.address")]); !!}
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

