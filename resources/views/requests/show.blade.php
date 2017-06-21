@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.status_message')

                <h1>{{$request->service_request_id}} <small>{{$request->created_at}}</small></h1>

                @include('requests.one', ['class' => $request->status == 'open' ? 'panel-primary' : 'panel-default'])
            </div>
        </div>
    </div>
@endsection
