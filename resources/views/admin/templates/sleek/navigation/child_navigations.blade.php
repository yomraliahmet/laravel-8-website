@if (isset($child_navigation["children_menus"]) && count($child_navigation["children_menus"]) > 0)

    <li  class="has-sub" >
        <a class="sidenav-item-link" href="javascript:void(0)" data-id="{{ $child_navigation["id"] }}" data-toggle="collapse" data-target="#sub_menu_{{ $child_navigation["id"] ?? "" }}"
           aria-expanded="false" aria-controls="sub_menu_{{ $child_navigation["id"] ?? "" }}">
            <i class="{{ $child_navigation["icon"] ?? "mdi mdi-arrow-right-bold" }} mr-2"></i>
            @foreach($child_navigation["translations"] as $key => $translate)
                @if($translate["locale"] == app()->getLocale())
                    <span class="nav-text">{{ $translate["name"] ?? "" }}</span> <b class="caret"></b>
                @endif
            @endforeach
        </a>
        <ul  class="collapse"  id="sub_menu_{{ $child_navigation["id"] ?? "" }}">
            <div class="sub-menu">
                @foreach ($child_navigation["children_menus"] as $childNavigation)
                    @include(config("admin.view_path").".navigation.child_navigations",['child_navigation' => $childNavigation])
                @endforeach
            </div>
        </ul>


    </li>

@else
    @if(in_array($child_navigation["permission"],$permissions))
        @php
            $url = "#";
            if(\Illuminate\Support\Facades\Route::has($child_navigation["route"])) $url = route($child_navigation["route"]);
            if(! is_null($child_navigation["url"])) $url = $child_navigation["url"];

            $active = "";
            if(request()->route()->getAction("as") == $child_navigation["route"]) $active = "active";

        @endphp
        <li class="{{ $active }}">
            <a class="sidenav-item-link" href="{{ $url }}" target="{{ $child_navigation["target"] }}">
                <i class="{{ $child_navigation["icon"] ?? "mdi mdi-arrow-right-bold" }} mr-2"></i>
                @foreach($child_navigation["translations"] as $key => $translate)
                    @if($translate["locale"] == app()->getLocale())
                        <span class="nav-text">{{ $translate["name"] ?? "" }}</span>
                    @endif
                @endforeach
            </a>
        </li>
    @endif
@endif
