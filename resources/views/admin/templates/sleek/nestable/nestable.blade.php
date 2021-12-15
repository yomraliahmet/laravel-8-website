@php
    function actions($id)
    {
        $data = [
            [
                "name" => trans("models.common.edit"),
                "icon" => "fa fas fa-edit",
                "class" => "btn-success btn-sm",
                "route" => route("admin.menu.edit",[$id]),
                "permission" => ["admin.menu.edit"],
            ],
            [
                "name" => trans("models.common.delete"),
                "icon" => "fa fa-trash",
                "class" => "btn-danger btn-sm",
                "route" => route("admin.menu.destroy",[$id]),
                "permission" => ["admin.menu.destroy"],
                "data" => 'data-method=DELETE data-token='.csrf_token().' data-confirm=Silmek istiyor musun?',
            ],
        ];

        return view('admin.crud.datatables.actions')
                    ->with('links', $data)
                    ->with('width', '60px');
    }
@endphp



<div class="dd" id="nestable">
    <ol class="dd-list">
        @foreach ($menus as $key => $menu)
            @if(count($menu["menus"]) > 0)
                <li class="dd-item" data-id="{{ $menu["id"] }}">
                    <div class="dd-handle">{{ $menu["name"] }}</div>
                    <div style="margin-top:-40px;margin-right:4px;z-index: 9999999;" class="float-right actions">{!! actions($menu["id"])!!}</div>
                    <ol class="dd-list">
                        @foreach ($menu["menus"] as $childNavigation)
                            @include(config("admin.view_path").".nestable.child_nestable",['child_navigation' => $childNavigation ])
                        @endforeach
                    </ol>
                </li>
            @else
                <li class="dd-item" data-id="{{ $menu["id"] }}">
                    <div class="dd-handle">{{ $menu["name"] }}</div>
                    <div style="margin-top:-40px;margin-right:4px;z-index: 9999999;" class="float-right actions">{!! actions($menu["id"]) !!}</div>
                </li>
            @endif
        @endforeach
    </ol>
</div>
