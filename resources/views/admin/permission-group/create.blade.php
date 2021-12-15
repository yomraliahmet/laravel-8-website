@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" :buttons="$buttons" icon="fa fa-plus"  type="default">
        @include("admin.alert")

        {!! Form::open(['id' => 'form', 'class' => 'ajax reset', 'route' => 'admin.permission-group.store', 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-6">
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('name', trans("models.permission-group.name")); !!}
                                        {!! Form::text($locale.'[name]' , null, ["id" => $locale."_name","class" => "form-control", "placeholder" => trans("models.permission-group.name")]); !!}
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    {!! Form::label('guard_name', trans("models.permission-group.guard_name")); !!}
                    {!! Form::select('guard_name', $guards, "admin", ["class" => "form-control placeholder", "placeholder" => trans("models.common.select")]); !!}
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('name', trans("models.permission-group.permission")); !!}
                    {!! Form::text('name[]' , null, ["id" =>"name","class" => "form-control", "placeholder" => trans("models.permission-group.permission")]); !!}
                    <div class="invalid-feedback"></div>
                </div>

                <button class="btn btn-default duplicate" type="button" id="button-addon2"><i class="fa fa-plus-circle"></i></button>
            </div>
        </div>

        {!! Form::close() !!}

    </x-card>

@endsection

@section("footerJS")
<script>
    $(function(){
       $("button.duplicate").on("click", function(){

           var element = '<div class="input-group mb-3 duplicate-element">\n' +
               '              <input type="text" name="name[]" id="name" class="form-control name" placeholder="{{ trans("models.permission-group.permission") }}" aria-label="{{ trans("models.permission-group.permission") }}" aria-describedby="basic-addon2">\n' +
               '              <div class="input-group-append">\n' +
               '                  <button class="btn btn-default remove" type="button" id="button-addon2"><i class="far fa-trash-alt text-danger"></i></button>\n' +
               '              </div>\n' +
               '              <div class="invalid-feedback"></div>\n' +
               '          </div>';

           $(this).prev().after(element);
       });

       $("body").on("click","button.remove", function(){
           $(this).parent().parent().remove();
       });

    });
</script>
@endsection
