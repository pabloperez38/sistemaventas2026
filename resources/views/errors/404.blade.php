@extends('layouts.admin')

@section('content')
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/compiled/svg/error-404.svg') }}" alt="Not Found" />
                    <h1 class="error-title">Error 404</h1>
                    <p class="fs-5 text-gray-600">
                        La página que estás buscando no está disponible.
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection
