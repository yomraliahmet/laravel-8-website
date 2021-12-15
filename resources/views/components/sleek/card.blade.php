@php
    $class = 'card-'.$attributes["type"];
    $headerClass = 'bg-'.$attributes["type"];
    $headerTextClass = $attributes["type"] != 'default' ? 'text-white' : '';
@endphp

<div class="card {{ $class ?? '' }}">
    <div class="card-header {{ $headerClass ?? '' }} justify-content-between card-header-border-bottom pt-3 pb-2">
        <h2 class="mb-2 {{ $headerTextClass ?? '' }}">{!! $attributes["icon"] ? '<i class="'.$attributes["icon"].' mr-1" style="font-size:0.9rem;"></i>' : '' !!} {{ $attributes["title"] ?? "" }}</h2>
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
