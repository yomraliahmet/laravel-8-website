@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" :buttons="$buttons" icon="fa fa-plus"  type="default">
        @include("admin.alert")

        {!! Form::open(['id' => 'form', 'class' => 'ajax reset', 'route' => 'admin.role.store', 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('guard_name', trans("models.role.guard_name")); !!}
                    {!! Form::select('guard_name', $guards, "admin", ["class" => "form-control placeholder", "placeholder" => trans("models.common.select")]); !!}
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('name', trans("models.role.name")); !!}
                    {!! Form::text('name[]' , null, ["id" =>"name","class" => "form-control", "placeholder" => trans("models.role.name")]); !!}
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
               '              <input type="text" name="name[]" id="name" class="form-control name" placeholder="{{ trans("models.role.name") }}" aria-label="{{ trans("models.role.name") }}" aria-describedby="basic-addon2">\n' +
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
