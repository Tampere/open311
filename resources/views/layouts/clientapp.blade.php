<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="admin-status" content="0">

    <title>{{ config('app.name', 'Open311') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bulma.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @if(auth()->check())
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
            </div>
            <div class="navbar-menu is-active">
                <div class="navbar-end">
                    <a class="navbar-item" href="{{ url('/client/manage') }}">
                        Manage personal information
                    </a>
                    <a class="navbar-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        Log out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </nav>
    @endif
    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Open311 Feedback API
                </h1>
                <h2 class="subtitle">
                    City of Tampere
                </h2>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>
    <Flash></Flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
