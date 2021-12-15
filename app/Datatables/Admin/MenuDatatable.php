<?php

namespace App\Datatables\Admin;

use App\Models\Menu;

class MenuDatatable
{
    private $model = Menu::class;
    private $translatePrefix = "models.menu.";

    /**
     * @return false|string
     */
    public function columns()
    {
        $checkbox = '  <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkAll">
                        <label class="custom-control-label" for="checkAll"></label>
                      </div>';

        $data = [
            ["responsivePriority" => 0, "name" => "move", "data" => "move", "header" => "#", 'searchable' => false, 'orderable' => false, 'width' => '30px'],
            ["responsivePriority" => 1, "name" => "checkbox", "data" => "checkbox", "header" => $checkbox, 'searchable' => false, 'orderable' => false, 'width' => '20px'],
            ["responsivePriority" => 2, "name" => "order", "data" => "order", "header" => trans($this->translatePrefix."order")],
            ["responsivePriority" => 3, "name" => "id", "data" => "id", "header" => trans($this->translatePrefix."id"), 'searchable' => false, 'orderable' => false],
            ["responsivePriority" => 4, "name" => "menu_id", "data" => "menu_id", "header" => trans($this->translatePrefix."menu_id"), 'searchable' => false, 'orderable' => false],
            ["responsivePriority" => 5, "name" => "name", "data" => "name", "header" => trans($this->translatePrefix."name")],
            ["responsivePriority" => 6, "name" => "permission", "data" => "permission", "header" => trans($this->translatePrefix."permission")],
            ["responsivePriority" => 7, "name" => "is_active", "data" => "is_active", "header" => trans($this->translatePrefix."status")],
            ["responsivePriority" => 0, 'name' => 'actions', 'data' => 'actions', 'header' => trans('models.common.actions'), 'searchable' => false, 'orderable' => false, 'width' => '110px'],
        ];

        $columns = json_encode($data);
        return $columns;
    }

    /**
     * @param $id
     * @return array[]
     */
    public function actions($id)
    {
        $data = [
            [
                "name" => trans("models.common.show"),
                "icon" => "fa fa-eye",
                "class" => "btn-primary btn-sm",
                "route" => route("admin.menu.show",[$id]),
                "permission" => "admin.menu.show",
            ],
            [
                "name" => trans("models.common.edit"),
                "icon" => "fa fas fa-edit",
                "class" => "btn-success btn-sm",
                "route" => route("admin.menu.edit",[$id]),
                "permission" => "admin.menu.edit",
            ],
            [
                "name" => trans("models.common.delete"),
                "icon" => "fa fa-trash",
                "class" => "btn-danger btn-sm",
                "route" => route("admin.menu.destroy",[$id]),
                "permission" => "admin.menu.destroy",
            ],
        ];

        return $data;
    }

    public function table($name = "table")
    {
        $buttons = [
            [
                "name" => trans("admin.common.add"),
                "icon" => "fa fa-plus",
                "class" => "btn btn-primary btn-md",
                "route" => route("admin.menu.create"),
                "permission" => "admin.menu.create",
            ]
        ];
        return view("admin.crud.datatables.table")
            ->with("name", $name)
            ->with("buttons", $buttons)
            ->with("title",trans("admin.menu.title"))
            ->with("url",route("admin.menu.datatable"))
            ->with("order", route("admin.menu.datatable.order"))
            ->with("selectedDestroy", route("admin.menu.selected.destroy"))
            ->with("deleteAllPermission", "admin.menu.selected.destroy")
            ->with("sort", 2)
            ->with("columns", $this->columns());
    }

    /**
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function datatable()
    {
        $query = $this->model::query()->with("menu.translations")->withTranslation();

        return datatables()->eloquent($query)
            ->setRowAttr([
                'data-id' => function ($model) {
                    return $model->id;
                },
            ])
            ->addColumn('actions', function ($model) {
                return view('admin.crud.datatables.actions')
                    ->with('links', $this->actions($model->id))
                    ->with('width', '110px');
            })
            ->editColumn('move', function($model){
                return '<div class="move ml-2"><i class="fas fa-arrows-alt"></i></div>';
            })
            ->editColumn('checkbox', function($model){
                $checkbox = '  <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkAll" data-id="'.$model->id.'" id="checkAll_'.$model->id.'">
                        <label class="custom-control-label" for="checkAll_'.$model->id.'"></label>
                      </div>';

                return $checkbox;
            })
            ->rawColumns(["permission","is_active","move","checkbox","menu_id"])
            ->editColumn("permission", function($model){
                if($model->permission){
                    return '<span class="right badge badge-primary">'.$model->permission.'</span>';
                }
                return '';
            })
            ->editColumn("is_active", function($model){
                $cssClass = "right badge badge-success";
                if(!$model->is_active) $cssClass = "right badge badge-danger";
                return '<span class="'.$cssClass.'">'.trans("models.menu.is_active.".$model->is_active).'</span>';
            })
            ->editColumn("menu_id", function($model){
                return $model->menu->name ?? "<small style='color: #a6a3a3;font-style: italic;'>null</small>";
            })
            ->filterColumn("name",function($query, $keyword){
                $query->whereTranslationLike('name', '%'.$keyword.'%');
            })
            ->filterColumn('is_active', function($query, $keyword) {
                $active = trans("models.menu.is_active.1");
                $passive = trans("models.menu.is_active.0");
                $query->whereRaw("IF(is_active = 1, '".$active."', '".$passive."') like ?", ["%{$keyword}%"]);
            })
            ->orderColumn("name", function($query, $order){
                $query->orderByTranslation('name',$order);
            })
            ->make(true);
    }

    public function order($orders)
    {
        foreach ($orders as $order) {
            $orderable = $this->model::query()->find($order['id']);
            $orderable->order = $order['order'];
            $orderable->save();
        }

        return true;
    }

}
