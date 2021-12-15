<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\Admin\AdminDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Image;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $table = (new AdminDatatable())->table();

        return view("admin.crud.index")
            ->with("title", trans("admin.admin.title"))
            ->with("table", $table);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $buttons = [
            \Button::backButton(route("admin.admin.index"),["admin.admin.index"]),
            \Button::ajaxSubmitButton("form",["admin.admin.store"])
        ];

        $roles = Role::all()->pluck('name',"name");

        return view("admin.admin.create")
            ->with("title", trans("admin.admin.new_title"))
            ->with("buttons", $buttons)
            ->with("roles",$roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $admin = new Admin();
        $admin->fill($request->input());
        $admin->save();
        $admin->syncRoles($request->input("roles"));

        if($request->hasFile("image")){
            if(! is_null($admin->image)){
                $admin->image()->delete();
            }

            $admin->image()->save(new Image([
                'image' => $request->file("image"),
            ]));
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
     * @param Admin $admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Admin $admin)
    {
        $buttons = [
            \Button::backButton(route("admin.admin.index"),["admin.admin.index"]),
            \Button::ajaxSubmitButton("form",["admin.admin.store"])
        ];

        $roles = Role::all()->pluck('name',"name");

        return view("admin.admin.edit")
            ->with("title", trans("admin.admin.edit_title"))
            ->with("roles",$roles)
            ->with("buttons", $buttons)
            ->with("model", $admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $admin->fill($request->input());
        $admin->save();
        $admin->syncRoles($request->input("roles"));

        if($request->hasFile("image")){
            if(! is_null($admin->image)){

                $file = public_path("images/".$admin->image->name);
                if(file_exists($file)){
                    @unlink($file);
                }

                $admin->image()->delete();
            }

            $admin->image()->save(new Image([
                'image' => $request->file("image"),
            ]));
        }

        auth()->guard("admin")->login($admin, true);

        return response()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if($admin->id != 1){
            $admin->delete();
        }

        return response()->success();
    }

    public function selectedDestroy(Request $request)
    {
        Admin::query()->where("id", "!=", 1)->whereIn("id",$request->input("id"))->delete();

        return response()->success();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable()
    {
        return (new AdminDatatable())->datatable();
    }
}
