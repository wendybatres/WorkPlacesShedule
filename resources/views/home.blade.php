@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>{{ __('¡Bienvenido!') }}</h1>
                    <h6>{{ __('Workplaces Schedule') }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
