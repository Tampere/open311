@extends('layouts.clientapp')

@section('content')
    <h1 class="title">Manage personal info</h1>
    <h2 class="subtitle">Here you can update your name, email and password</h2>

    <form action="{{url('client/manage')}}" method="post">
        {{csrf_field()}}
        {{--Update name, email--}}
        <div class="field">
            <label for="name" class="label">Name</label>
            <div class="control">
                <input class="input" id="name" name="name" type="text" value="{{old('name', auth()->user()->name)}}" required>
            </div>

            @if($errors->has('name'))
                <p class="help is-danger">{{$errors->get('name')[0]}}</p>
            @endif
        </div>

        <div class="field">
            <label for="email" class="label">Email</label>
            <div class="control">
                <input class="input" id="email" name="email" type="email" value="{{old('email', auth()->user()->email)}}" required>
            </div>

            @if($errors->has('email'))
                <p class="help is-danger">{{$errors->get('email')[0]}}</p>
            @endif
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link is-primary">Update</button>
            </div>
        </div>
    </form>

    <hr>

    <form action="{{url('client/manage/password')}}" method="post">
        {{csrf_field()}}
        {{--Update password--}}
        <div class="field">
            <label for="password" class="label">Password</label>
            <div class="control">
                <input class="input" id="password" name="password" type="password" required>
            </div>

            @if($errors->has('password'))
                <p class="help is-danger">{{$errors->get('password')[0]}}</p>
            @endif
        </div>

        <div class="field">
            <label for="password-confirm" class="label">Confirm password</label>
            <div class="control">
                <input class="input" id="password-confirm" name="password_confirmation" type="password" required>
            </div>

            @if($errors->has('password_confirmation'))
                <p class="help is-danger">{{$errors->get('password_confirmation')[0]}}</p>
            @endif
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link is-primary">Change password</button>
            </div>
        </div>
    </form>

@endsection
