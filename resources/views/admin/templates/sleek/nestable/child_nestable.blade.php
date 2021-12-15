@if (isset($child_navigation["children_menus"]) && count($child_navigation["children_menus"]) > 0)
    <li class="dd-item" data-id="{{ $child_navigation["id"] }}">
        <div class="dd-handle">{{ $child_navigation["name"] }}</div>
        <div style="margin-top:-40px;margin-right:4px;z-index: 9999999;" class="float-right actions">{!! actions($child_navigation["id"]) !!}</div>
        <ol class="dd-list">
            @foreach ($child_navigation["children_menus"] as $childNavigation)
                @include(config("admin.view_path").".nestable.child_nestable",['child_navigation' => $childNavigation])
            @endforeach
        </ol>
    </li>
@else
    <li class="dd-item" data-id="{{ $child_navigation["id"] }}">
        <div class="dd-handle">{{ $child_navigation["name"] }}</div>
        <div style="margin-top:-40px;margin-right:4px;z-index: 9999999;" class="float-right actions">{!! actions($child_navigation["id"]) !!}</div>
    </li>
@endif
