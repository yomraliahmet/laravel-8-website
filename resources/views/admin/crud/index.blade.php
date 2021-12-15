@extends(config("admin.layout"))

@section("title", $title)

@section("content")
    @if(is_array($table) && count($table) > 0)
        @foreach($table as $newTable)
            {!! $newTable !!}
        @endforeach
    @else
        {!! $table ?? "" !!}
    @endif

@endsection


