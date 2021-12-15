<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalController extends Controller
{
    public function jsTrranslation()
    {
        $content = 'window.translations = '.Cache::get('translations');

        return response($content,200,[
            "Content-Type" => "text/javascript",
            "charset" => "utf-8",
            "Cache-Control" => "max-age=31536000, private"
        ]);
    }
}
