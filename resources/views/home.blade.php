@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="jumbotron">
            <h5>Welcome, {{ auth()->user()->email }}</h5>
            <h1 class="display-3">Laravel Fortify Authentication</h1>
            <hr class="my-4">
            <h2>Features:</h2>
            <div>
                @if(!auth()->user()->two_factor_secret)
                    Not enabled
                    <form method="post" action="{{ url('user/two-factor-authentication') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Enable</button>
                    </form>
                @else
                    enabled
                    <form method="post" action="{{ url('user/two-factor-authentication') }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Disable</button>
                    </form>
                    <p>Recovery codes</p>
                    @foreach(auth()->user()->recoveryCodes() as $code)
                        {{ $code }}<br>

                    @endforeach
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                @endif

                @if (session('status') == 'two-factor-authentication-enabled')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        Two factor authentication has been enabled.
                    </div>
                @endif
            </div>
            
        </div>
    </div>
@endsection
