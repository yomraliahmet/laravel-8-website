@php
    $user = auth("admin")->user();
    $permissions = $user->getAllPermissions()->pluck("name","name")->toArray();
@endphp
@foreach($menus as $key => $menu)
    @if(count($menu["menus"]) > 0)
        <li  class="nav-item has-treeview" >
            <a href="#" class="nav-link" data-id="{{ $menu["id"] }}">
                <i class="nav-icon {{ $menu["icon"] ?? "fas fa-circle" }}"></i>
                <p>
                    {{ $menu["name"] }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                @foreach ($menu["menus"] as $childNavigation)
                    @include(config("admin.view_path").".navigation.child_navigations",['child_navigation' => $childNavigation, 'icon' => 'far fa-circle'])
                @endforeach
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

            <li class="nav-item">
                <a href="{{ $url }}" class="nav-link {{ $active }}">
                    <i class="nav-icon {{ $menu["icon"] ?? "fas fa-circle" }}"></i>
                    <p>
                        {{ $menu["name"] }}
                    </p>
                </a>
            </li>
        @endif
    @endif
@endforeach

