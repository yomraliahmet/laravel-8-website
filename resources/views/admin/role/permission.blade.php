@extends(config("admin.layout"))

@section("title", $title)

@section("content")

    <x-card :title="$title" :buttons="$buttons" icon="fas fa-key"  type="default">
        @include("admin.alert")

        {!! Form::open(['id' => 'form', 'class' => 'ajax', 'route' => ['admin.role.permission',$role->id], 'method' => 'post']) !!}
        <div class="row">
            @foreach($permissionGroups as $key => $permissionGroup)
                <div class="col-sm-6 col-md-6 col-lg-4 permissionList" data-count="{{ $permissionGroup->permissions->count() }}">

                    <x-card :title="$permissionGroup->name" icon="fa fa-list"  type="primary">
                        @if($permissionGroup->permissions->count() == 0)
                            <p class="h5 text-danger">{{ trans("admin.common.not_found") }}</p>
                        @else
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" name="checkAll_{{ $key }}" class="custom-control-input checkAllTop" id="checkAll_{{ $key }}">
                                <label class="custom-control-label" for="checkAll_{{ $key }}">{{ trans("admin.common.select_all") }}</label>
                            </div>
                        <hr/>
                        <ul class="m-0 p-0" style="list-style: none;">
                            @foreach($permissionGroup->permissions as $permission)
                                <li>
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input {{ $role->hasPermissionTo($permission->name) ? "checked" : "" }} value="{{ $permission->name ?? "" }}" type="checkbox" name="name[]" class="custom-control-input checkAll" id="{{ $permission->name ?? "" }}">
                                        <label style="word-break:break-all" class="custom-control-label" for="{{ $permission->name ?? "" }}">{{ $permission->name ?? "" }}</label>
                                    </div>
                                </li>

                            @endforeach
                        </ul>

                        @endif

                    </x-card>
                </div>
            @endforeach
        </div>

        {!! Form::close() !!}

    </x-card>

@endsection

@section("footerJS")
<script>
    $(function(){
        $("input.checkAllTop").on("change", function(){
            var el = $(this).closest(".card-body").find(".checkAll").not(0);
            if($(this).prop("checked")){
                el.prop("checked",true);
            }else{
                el.prop("checked",false);
            }
        });

        $(".permissionList").each(function (k, el){
            var count = $(el).data("count");
            var elCount = $(el).find("ul input[type=checkbox]:checked").length;
            if(count === elCount){
                $(el).find("input[type=checkbox]:first").prop("checked", true);
            }
        });
    });
</script>
@endsection
