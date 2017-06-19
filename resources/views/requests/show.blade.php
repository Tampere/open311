@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1>{{$request->service_request_id}} <small>{{$request->created_at}}</small></h1>

                @include('requests.one')
            </div>
        </div>
    </div>
@endsection
