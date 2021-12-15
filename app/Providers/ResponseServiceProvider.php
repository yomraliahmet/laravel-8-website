<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro("redirectToJson", function(string $url, $data = [], int $status = 200, array $headers = [], int $options = 0): JsonResponse {

            $arr = ['url' => $url];
            if(isset($data["code"])) $arr["code"] = $data["code"];
            if(isset($data["message"])) $arr["message"] = $data["message"];

            return response()->json($arr, $status, $headers, $options);
        });

        Response::macro("success", function(string $message = null, $data = [], int $status = 200, array $headers = [], int $options = 0): JsonResponse {
            $arr = [
                'code'    => $data["code"] ?? "success",
                'title'   => $data["title"] ?? trans('messages.common.success_title'),
                'message' => $message ?? trans('messages.common.success_message'),
            ];

            if(isset($data["url"])) $arr["url"] = $data["url"];
            if(isset($data["token"])) $arr["token"] = $data["token"];
            if(isset($data["data"])) $arr["data"] = $data["data"] ?? [];

            return response()->json($arr, $status, $headers, $options);
        });

        Response::macro("error", function(string $message = null, $data = [], int $status = 400, array $headers = [], int $options = 0): JsonResponse{

            $arr = [
                'code'    => $data["code"] ?? "error",
                'title'   => $data["title"] ?? trans('errors.common.error_title'),
                'message' => $message ?? trans('messages.common.success_message'),
            ];

            if(isset($data["url"])) $arr["url"] = $data["url"];
            if(isset($data["data"])) $arr["data"] = $data["data"] ?? [];

            return response()->json($arr, $status, $headers, $options);
        });

    }
}
