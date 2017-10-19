@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{$title}}</h1>

                @include('layouts.status_message')

                <requests></requests>
            </div>
        </div>
    </div>
@endsection
