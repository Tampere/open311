@extends('layouts.clientapp')

@section('content')
    <div class="columns">
        <div class="column">
            <h1 class="title">Developer wanting to create a shiny new app?</h1>
            <h2 class="subtitle">Register for API key</h2>
            <form action="/clientregister" method="POST">
                {{csrf_field()}}
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input" type="text" name="name" placeholder="Jane Doe" required>
                    </div>

                    @if($errors->has('name'))
                        <p class="help is-danger">{{$errors->get('name')[0]}}</p>
                    @endif
                </div>

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Email input" required>
                    </div>

                    @if($errors->has('email'))
                        <p class="help is-danger">{{$errors->get('email')[0]}}</p>
                    @endif
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" name="password" required>
                    </div>

                    @if($errors->has('password'))
                        <p class="help is-danger">{{$errors->get('password')[0]}}</p>
                    @endif
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Register</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
            <h1 class="title">Developer who has a shiny new app?</h1>
            <h2 class="subtitle">Login to grap or change your API key</h2>
            <form action="/login" method="POST">
                {{csrf_field()}}
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Email input" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" name="password" type="password" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-link">Log in</button>
                    </div>
                </div>
                <p>
                    <a href="{{url('/client/reset')}}">Forgot your password?</a>
                </p>
            </form>
        </div>
    </div>
@endsection
