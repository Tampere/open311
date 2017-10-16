@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('layouts.status_message')

                <h1><a href="{{route('requests.index')}}">&laquo; Back to listing</a></h1>

                <request-view :request="{{$request}}"></request-view>
            </div>
        </div>
    </div>
@endsection
