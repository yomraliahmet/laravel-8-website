<div id="top-header">
    <div class="container">
        <ul class="header-links pull-left">
            <li><a href="tel:{{ $config["contact"]["phone"] ?? null }}"><i class="fa fa-phone"></i> {{ $config["contact"]["phone"] ?? null }}</a></li>
            <li><a href="mailto:{{ $config["contact"]["email"] ?? null }}"><i class="fa fa-envelope-o"></i> {{ $config["contact"]["email"] ?? null }}</a></li>
            <li><a target="_blank" href="https://www.google.com/maps/search/{{ $config["contact"]["address"] ?? null }}"><i class="fa fa-map-marker"></i> {{ $config["contact"]["address"] ?? null }}</a></li>
        </ul>
        <ul class="header-links pull-right">
            <li><a href="#"><i class="fa {{ ($config["currency"] ?? null) == \App\Models\Setting::CURRENCIES_TRY ? 'fa-try' : 'fa-dollar' }}"></i> {{ ($config["currency"] ?? null ) }}</a></li>
            @auth
                <li><a href="{{ route("web.user.show",[auth()->user()->id]) }}"><i class="fa fa-user-o"></i> {{ trans("web.common.account") }}</a></li>
                <li>
                    <form action="{{ route("web.logout") }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-xs">
                            <i class="fa fa-sign-out"></i> {{ trans("web.common.logout") }}
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route("web.login-and-register") }}"><i class="fa fa-user-o"></i> {{ trans("web.common.my_account") }}</a></li>
            @endauth
        </ul>
    </div>
</div>
