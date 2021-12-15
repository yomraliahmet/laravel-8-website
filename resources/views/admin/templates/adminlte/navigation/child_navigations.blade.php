@if (isset($child_navigation["children_menus"]) && count($child_navigation["children_menus"]) > 0)

    <li class="nav-item has-treeview">
        <a href="#" class="nav-link" data-id="{{ $child_navigation["id"] }}">
            <i class="nav-icon {{ $child_navigation["icon"] ?? $icon }}"></i>
            <p>
                {{ $child_navigation["name"] }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            @foreach ($child_navigation["children_menus"] as $childNavigation)
                @include(config("admin.view_path").".navigation.child_navigations",['child_navigation' => $childNavigation, 'icon' => 'far fa-dot-circle'])
            @endforeach
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

        <li class="nav-item">
            <a href="{{ $url }}" class="nav-link {{ $active }}">
                <i class="nav-icon {{ $child_navigation["icon"] ?? $icon }}"></i>
                <p>{{ $child_navigation["name"] }}</p>
            </a>
        </li>
    @endif
@endif
