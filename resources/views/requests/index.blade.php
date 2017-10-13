@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Pending and open requests</h1>

                @include('layouts.status_message')

                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Created at</th>
                            <th>Title</th>
                            <th>Decription</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $request)
                            @include('requests.one')
                        @empty
                            <tr>
                                <td colspan="6"><em>No pending or open requests</em></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <button class="btn btn-danger" disabled>Poista valitut</button>

                <p class="text-muted"><em>Showing {{$requests->count()}} out of {{$requests->total()}} pending or open requests</em></p>

                {{$requests->links()}}
            </div>
        </div>
    </div>
@endsection
