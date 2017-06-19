@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Archived requests</h1>

                @forelse ($requests as $request)
                    @include('requests.one', ['class' => 'panel-default'])
                @empty
                    <p><em>There are no archived requests</em></p>
                @endforelse

                {{$requests->links()}}
            </div>
        </div>
    </div>
@endsection
