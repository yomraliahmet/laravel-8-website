@extends(config("admin.layout"))

@section("content")

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-mini mb-4">
                    <div class="card-body">
                        <h2>Merhaba {{ auth()->user()->name }}</h2>
                    </div>
                </div>
            </div>
        </div>

@endsection
