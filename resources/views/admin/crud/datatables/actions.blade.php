<div {{ isset($width) ? 'style=min-width:'.$width : '' }} >
    @foreach($links as $link)
        @canany($link["permission"])
            <a href="{{ $link["route"] }}" {!! $link["data"] ?? "" !!} class="btn {{ $link["class"] }}" title="{{ $link["name"] }}"><i class="{{ $link["icon"] }}"></i></a>
        @endcanany
    @endforeach
</div>

