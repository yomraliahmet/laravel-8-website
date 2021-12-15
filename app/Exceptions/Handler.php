<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof AuthenticationException){
            if($request->isJson() || $request->ajax()){
                return Response::error("status.401", 401);
            }
        }

        if($e instanceof AuthorizationException){

            if($request->isJson() || $request->ajax()){
                if(in_array("login",explode(".",$request->route()->getName()))){
                    return Response::error("messages.common.login_error", 403);
                }
                return Response::error("status.403", 403);
            }
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (in_array('admin', $exception->guards())) {
            return redirect()->route('admin.login');
        }
        return redirect()->route('home');
    }
}
