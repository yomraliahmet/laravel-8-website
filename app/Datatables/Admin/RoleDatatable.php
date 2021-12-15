<?php

namespace App\Datatables\Admin;

use Spatie\Permission\Models\Role;

class RoleDatatable
{
    private $model = Role::class;
    private $translatePrefix = "models.role.";

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
            ["responsivePriority" => 1, "name" => "checkbox", "data" => "checkbox", "header" => $checkbox, 'searchable' => false, 'orderable' => false, 'width' => '20px'],
            ["responsivePriority" => 2, "name" => "id", "data" => "id", "header" => trans($this->translatePrefix."id"), 'searchable' => false, 'orderable' => false],
            ["responsivePriority" => 3, "name" => "name", "data" => "name", "header" => trans($this->translatePrefix."name")],
            ["responsivePriority" => 4, "name" => "guard_name", "data" => "guard_name", "header" => trans($this->translatePrefix."guard_name")],
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
                "name" => trans("models.common.permissions"),
                "icon" => "fas fa-key",
                "class" => "btn-info btn-sm",
                "route" => route("admin.role.permission",[$id]),
                "permission" => "admin.role.permission",
            ],
            [
                "name" => trans("models.common.edit"),
                "icon" => "fa fas fa-edit",
                "class" => "btn-success btn-sm",
                "route" => route("admin.role.edit",[$id]),
                "permission" => "admin.role.edit",
            ],
            [
                "name" => trans("models.common.delete"),
                "icon" => "fa fa-trash",
                "class" => "btn-danger btn-sm",
                "route" => route("admin.role.destroy",[$id]),
                "permission" => "admin.role.destroy",
                "data" => "data-method=DELETE data-confirm='".trans("admin.common.delete_title")."' data-token=". csrf_token()." data-ajax=1",
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
                "class" => "btn bg-primary btn-tool text-white",
                "route" => route("admin.role.create"),
                "permission" => "admin.role.create",
            ]
        ];
        return view("admin.crud.datatables.table")
            ->with("name", $name)
            ->with("buttons", $buttons)
            ->with("title",trans("admin.role.title"))
            ->with("url",route("admin.role.datatable"))
            ->with("selectedDestroy", route("admin.role.selected.destroy"))
            ->with("deleteAllPermission", "admin.role.selected.destroy")
            ->with("sort", 1)
            ->with("columns", $this->columns());
    }

    /**
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function datatable()
    {
        $query = $this->model::query();

        return datatables()->eloquent($query)
            ->setRowAttr([
                'data-id' => function ($model) {
                    return $model->id;
                },
            ])
            ->addColumn('actions', function ($model) {
                return view('admin.crud.datatables.actions')
                    ->with('links', $this->actions($model->id))
                    ->with('width', '70px');
            })
            ->rawColumns(["checkbox"])
            ->editColumn('checkbox', function($model){
                $checkbox = '  <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkAll" data-id="'.$model->id.'" id="checkAll_'.$model->id.'">
                        <label class="custom-control-label" for="checkAll_'.$model->id.'"></label>
                      </div>';

                return $checkbox;
            })
            ->make(true);
    }
}
