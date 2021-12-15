<?php

namespace App\Datatables\Admin;

use App\Models\Admin;

class AdminDatatable
{
    private $model = Admin::class;
    private $translatePrefix = "models.admin.";

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
            ["responsivePriority" => 3, "name" => "name", "data" => "name", "header" => trans($this->translatePrefix."name")],
            ["responsivePriority" => 4, "name" => "email", "data" => "email", "header" => trans($this->translatePrefix."email")],
            ["responsivePriority" => 5, "name" => "roles", "data" => "roles", "header" => trans($this->translatePrefix."roles"), 'orderable' => false],
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
                "route" => route("admin.admin.edit",[$id]),
                "permission" => "admin.admin.edit",
            ],
            [
                "name" => trans("models.common.delete"),
                "icon" => "fa fa-trash",
                "class" => "btn-danger btn-sm",
                "route" => route("admin.admin.destroy",[$id]),
                "permission" => "admin.admin.destroy",
                "data" => "data-method=DELETE data-confirm='".trans("admin.common.delete_title")."' data-token=". csrf_token()." data-ajax=1",
            ],
        ];

        if($id == 1){
            unset($data[1]);
        }

        return $data;
    }

    public function table($name = "table")
    {
        $buttons = [
            [
                "name" => trans("admin.common.add"),
                "icon" => "fa fa-plus",
                "class" => "btn bg-primary btn-tool text-white",
                "route" => route("admin.admin.create"),
                "permission" => "admin.admin.create",
            ]
        ];
        return view("admin.crud.datatables.table")
            ->with("name", $name)
            ->with("buttons", $buttons)
            ->with("title",trans("admin.admin.title"))
            ->with("url",route("admin.admin.datatable"))
            ->with("selectedDestroy", route("admin.admin.selected.destroy"))
            ->with("deleteAllPermission", "admin.admin.selected.destroy")
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
        $query = $this->model::query()->with("roles");

        return datatables()->eloquent($query)
            ->setRowAttr([
                'data-id' => function ($model) {
                    return $model->id;
                }
            ])
            ->addColumn('actions', function ($model) {
                return view('admin.crud.datatables.actions')
                    ->with('links', $this->actions($model->id))
                    ->with('width', '70px');
            })
            ->rawColumns(["roles","checkbox"])
            ->editColumn("roles", function($model){
                $rolesHtml = '';
                foreach ($model->getRoleNames() as $role){
                    $rolesHtml .= '<span class="right badge badge-primary m-1">'.$role.'</span>';
                }
                return $rolesHtml;
            })
            ->editColumn('checkbox', function($model){
                $checkbox = '  <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkAll" data-id="'.$model->id.'" id="checkAll_'.$model->id.'">
                        <label class="custom-control-label" for="checkAll_'.$model->id.'"></label>
                      </div>';

                return $checkbox;
            })
            ->filterColumn("roles",function($query, $keyword){
                $query->whereHas('roles', function($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })

            ->orderColumn("name", function($query, $order){
                $query->orderByTranslation('name',$order);
            })
            ->make(true);
    }
}
