@extends(config('admin.layout'))

@section("title", $title)

@section("content")

    <x-card :title="$title" type="default">
        <h4>Hoşgeldin {{ auth()->guard("admin")->user()->name ?? "" }}</h4>
    </x-card>

@endsection
