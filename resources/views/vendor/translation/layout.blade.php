@extends(config("admin.layout"))
@section("content")
    <div id="app" class="translation-page">

        {{-- @include('translation::nav')--}}
        @include('translation::notifications')

        @yield('body')

    </div>
@endsection

@section("cssFile")
   <link rel="stylesheet" href="{{ asset('/vendor/translation/css/main.css') }}">
@endsection

@section("css")
    <style>
        div.content-header{display: none;}
    </style>
@endsection


