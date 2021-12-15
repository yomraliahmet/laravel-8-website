<?php

namespace App\Datatables\Admin;

use App\Models\PermissionGroup;

class PermissionGroupDatatable
{
    private $model = PermissionGroup::class;
    private $translatePrefix = "models.permission-group.";

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
            ["responsivePriority" => 1, "name" => "id", "data" => "id", "header" => trans($this->translatePrefix."id"), 'searchable' => false, 'orderable' => false],
            ["responsivePriority" => 2, "name" => "name", "data" => "name", "header" => trans($this->translatePrefix."name")],
            ["responsivePriority" => 3, "name" => "permissions", "data" => "permissions", "header" => trans($this->translatePrefix."permissions"), 'orderable' => false],
            ["responsivePriority" => 0, 'name' => 'actions', 'data' => 'actions', 'header' => trans('models.common.actions'), 'searchable' => false, 'orderable' => false, 'width' => '70px'],
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
                "name" => trans("models.common.edit"),
                "icon" => "fa fas fa-edit",
                "class" => "btn-success btn-sm",
                "route" => route("admin.permission-group.edit",[$id]),
                "permission" => "admin.permission-group.edit",
            ],
            [
                "name" => trans("models.common.delete"),
                "icon" => "fa fa-trash",
                "class" => "btn-danger btn-sm",
                "route" => route("admin.permission-group.destroy",[$id]),
                "permission" => "admin.permission-group.destroy",
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
                "route" => route("admin.permission-group.create"),
                "permission" => "admin.permission-group.create",
            ]
        ];
        return view("admin.crud.datatables.table")
            ->with("name", $name)
            ->with("buttons", $buttons)
            ->with("title",trans("admin.permission-group.title"))
            ->with("url",route("admin.permission-group.datatable"))
            ->with("selectedDestroy", route("admin.permission-group.selected.destroy"))
            ->with("deleteAllPermission", "admin.permission-group.selected.destroy")
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
        $query = $this->model::query()->with("permissions")->withTranslation();

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
            ->rawColumns(["permissions","checkbox"])
            ->editColumn("permissions", function($model){
                $permissionHtml = '';
                foreach ($model->permissions as $permission){
                    $permissionHtml .= '<span class="right badge badge-primary m-1">'.$permission->name.'</span>';
                }
                return $permissionHtml;
            })
            ->editColumn('checkbox', function($model){
                $checkbox = '  <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkAll" data-id="'.$model->id.'" id="checkAll_'.$model->id.'">
                        <label class="custom-control-label" for="checkAll_'.$model->id.'"></label>
                      </div>';

                return $checkbox;
            })
            ->filterColumn("name",function($query, $keyword){
                $query->whereTranslationLike('name', '%'.$keyword.'%');
            })
            ->filterColumn("permissions",function($query, $keyword){
                $query->whereHas('permissions', function($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->orderColumn("name", function($query, $order){
                $query->orderByTranslation('name',$order);
            })
            ->make(true);
    }
}
