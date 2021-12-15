<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Request;
use App\Models\Admin;
use App\Models\Image;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.home.index');
        }

        $defaultAdminInfo = [
            'email'         => 'admin@admin.com',
            'password'      => '123456',
        ];

        return view($this->adminViewTemplatePath().'.login')
            ->with('admin', $defaultAdminInfo);
    }

    public function postLogin(Request $request)
    {
        $isSuccess = Auth::guard('admin')->attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if (!$isSuccess) {
            $error = [
                'code'    => 'validation',
                'title'   => trans('errors.common.error_title'),
                'message' => trans('errors.common.login_validation'),
            ];
            $response = response()->error(trans('errors.common.login_validation'),$error);
            throw new HttpResponseException($response);
        }

        return response()->redirectToJson(route("admin.home.index"));
    }

    public function getProfile(Admin $admin)
    {
        return view("admin.profile.edit")
            ->with("title", trans("admin.profile.title"))
            ->with("model", $admin);
    }

    public function updateProfile(AdminRequest $request, Admin $admin)
    {
        $admin->fill($request->input());
        $admin->save();

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

    public function getLogout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        return redirect()->route('admin.login');
    }

}
