@php
    $user = auth("admin")->user();
    $permissions = $user->getAllPermissions()->pluck("name","name")->toArray();
@endphp

@foreach($menus as $key => $menu)
    @if(count($menu["menus"]) > 0)
        <li  class="has-sub" >
            <a class="sidenav-item-link" href="javascript:void(0)" data-id="{{ $menu["id"] }}" data-toggle="collapse" data-target="#menu_{{ $menu["id"] ?? "" }}"
               aria-expanded="false" aria-controls="menu_{{ $menu["id"] ?? "" }}">
                <i class="{{ $menu["icon"] ?? "mdi mdi-arrow-right-bold" }}"></i>
                @foreach($menu["translations"] as $key => $translate)
                    @if($translate["locale"] == app()->getLocale())
                        <span class="nav-text">{{ $translate["name"] ?? "" }}</span> <b class="caret"></b>
                    @endif
                @endforeach
            </a>
            <ul  class="collapse"  id="menu_{{ $menu["id"] ?? "" }}"
                 data-parent="#sidebar-menu">
                <div class="sub-menu">
                    @foreach ($menu["menus"] as $childNavigation)
                        @include(config("admin.view_path").".navigation.child_navigations",['child_navigation' => $childNavigation])
                    @endforeach
                </div>
            </ul>


        </li>
    @else
        @if(in_array($menu["permission"],$permissions))
            @php
                $url = "#";
                if(\Illuminate\Support\Facades\Route::has($menu["route"])) $url = route($menu["route"]);
                if(! is_null($menu["url"])) $url = $menu["url"];

                $active = "";
                if(request()->route()->getAction("as") == $menu["route"]) $active = "active";

            @endphp
            <li class="{{ $active }}">
                <a class="sidenav-item-link" href="{{ $url }}" target="{{ $menu["target"] }}">
                    <i class="{{ $menu["icon"] ?? "mdi mdi-arrow-right-bold" }}"></i>
                    @foreach($menu["translations"] as $key => $translate)
                        @if($translate["locale"] == app()->getLocale())
                            <span class="nav-text">{{ $translate["name"] ?? "" }}</span>
                        @endif
                    @endforeach
                </a>
            </li>
        @endif
    @endif
@endforeach
