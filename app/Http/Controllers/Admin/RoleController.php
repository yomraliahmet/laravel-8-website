<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\Admin\RoleDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $table = (new RoleDatatable())->table();

        return view("admin.crud.index")
            ->with("title", trans("admin.role.title"))
            ->with("table", $table);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $buttons = [
            \Button::backButton(route("admin.role.index"),["admin.role.index"]),
            \Button::ajaxSubmitButton("form",["admin.role.store"])
        ];

        $guardKeys = array_keys(config("auth.guards"));
        $guards = array_combine($guardKeys, $guardKeys);

        return view("admin.role.create")
            ->with("title", trans("admin.role.new_title"))
            ->with("buttons", $buttons)
            ->with("guards", $guards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        foreach ($request->input("name") as $name){
            $data = ["name" => $name, "guard_name" => $request->input("guard_name")];
            Role::create($data);
        }

        return response()->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Role $role)
    {
        $buttons = [
            \Button::backButton(route("admin.role.index"),["admin.role.index"]),
            \Button::ajaxSubmitButton("form",["admin.role.update"])
        ];

        $guardKeys = array_keys(config("auth.guards"));
        $guards = array_combine($guardKeys, $guardKeys);

        return view("admin.role.edit")
            ->with("title", trans("admin.role.edit_title"))
            ->with("model", $role)
            ->with("buttons", $buttons)
            ->with("guards", $guards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->fill($request->input());
        $role->save();

        return response()->success();
    }

    public function getPermission(Role $role)
    {
        $buttons = [
            \Button::backButton(route("admin.role.index"),["admin.role.index"]),
            \Button::ajaxSubmitButton("form",["admin.role.permission"])
        ];

        $permissionGroups = PermissionGroup::query()->with("permissions")->get();

        return view("admin.role.permission")
            ->with("title", trans("models.common.permissions"))
            ->with("role", $role->load("permissions"))
            ->with("permissionGroups", $permissionGroups)
            ->with("buttons", $buttons);
    }

    public function setPermission(Request $request, Role $role)
    {
        $role->syncPermissions($request->input("name"));

        return response()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->success();
    }

    public function selectedDestroy(Request $request)
    {
        Role::query()->whereIn("id",$request->input("id"))->delete();

        return response()->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable()
    {
        return (new RoleDatatable())->datatable();
    }
}
