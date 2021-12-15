<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\Web\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getLoginAndRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('web.home.index');
        }

        $defaultUserInfo = [
            'email'         => 'user@user.com',
            'password'      => '123456',
        ];

        return view('web.auth.login-and-register')
            ->with('user', $defaultUserInfo);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $isSuccess = Auth::guard('web')->attempt([
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

        return response()->redirectToJson(route("home"));
    }

    /**
     * @param UserRegisterRequest $request
     * @return mixed
     */
    public function postRegister(UserRegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->save();

        return response()->redirectToJson(route("home"));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        return redirect()->route('web.login-and-register');
    }
}
