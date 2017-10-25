@extends('layouts.clientapp')

@section('content')

    <h1 class="title">Here's your API key</h1>
    <h2 class="subtitle">If you leak it, click regenerate key to get a fresh copy</h2>

    <api-key data="{{auth()->user()->api_key}}"></api-key>

    <h2 class="subtitle">If you so choose, you can also destroy all evidence you were ever here</h2>

    <form action="/clientdestroy" method="POST">
        {{csrf_field()}}
        <button type="submit" class="button is-danger is-large">Permanently delete account</button>
    </form>
@endsection
