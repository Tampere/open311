@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.status_message')

                @foreach($users as $user)
                    @include('users.one')
                @endforeach

                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/register" class="btn btn-primary">Lisää uusi käyttäjä</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
