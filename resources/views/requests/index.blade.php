@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Pending requests</h1>

                @forelse ($requests as $request)
                    @include('requests.one', ['class' => 'panel-primary'])
                @empty
                    <p><em>There are no pending requests</em></p>
                @endforelse

                {{$requests->links()}}
            </div>
        </div>
    </div>
@endsection
