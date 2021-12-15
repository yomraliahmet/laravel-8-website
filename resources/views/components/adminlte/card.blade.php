@php
    $class = 'card-'.$attributes["type"];
@endphp

<div class="card {!! $class !!}">
    <div class="card-header">
        <h2 class="card-title">{!! $attributes["icon"] ? '<i class="'.$attributes["icon"].' mr-1" style="font-size:0.9rem;"></i>' : '' !!} {{ $attributes["title"] ?? "" }}</h2>
        @if(!is_null($attributes["buttons"]))
            <div class="card-tools">
                @foreach($attributes["buttons"] as $button)
                    @can($button["permission"])
                        @if(isset($button["form"]))
                            <button type="submit" form="{{ $button["form"] ?? "" }}" class="{{ $button["class"] ?? "" }}"><i class="{{ $button["icon"] ?? "" }}"></i> {{ $button["name"] ?? "" }}</button>
                        @else
                            <a class="{{ $button["class"] ?? "" }}" href="{{ $button["route"] ?? "#" }}"><i class="{{ $button["icon"] ?? "" }}"></i> {{ $button["name"] ?? "" }}</a>
                        @endif
                    @endcan
                @endforeach
            </div>
        @endif
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>

</div>
