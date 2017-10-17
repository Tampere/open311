@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Pending requests</h3>
                            <hr>
                            <p><strong>Count: </strong>{{$pending->count()}}</p>
                            <p>
                                @if($pending->count() > 0)
                                    <ul>
                                        @foreach($pending->take(5) as $item)
                                            <li><a href="/requests/{{$item->service_request_id}}">{{$item->service_request_id}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Open requests</h3>
                            <hr>
                            <p><strong>Count: </strong>{{$open->count()}}</p>
                            <p>
                            @if($open->count() > 0)
                                <ul>
                                    @foreach($open->take(5) as $item)
                                        <li><a href="/requests/{{$item->service_request_id}}">{{$item->service_request_id}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                                </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Closed requests</h3>
                            <hr>
                            <p><strong>Count: </strong>{{$closed->count()}}</p>
                            <p>
                            @if($closed->count() > 0)
                                <ul>
                                    @foreach($closed->take(5) as $item)
                                        <li><a href="/requests/{{$item->service_request_id}}">{{$item->service_request_id}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                                </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Breakdown</h3>
                            <hr>
                            <chart-renderer :data="{{json_encode($data)}}" :options="{}"></chart-renderer>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Notifications</div>

                <div class="panel-body">
                    <div class="list-group">
                    @forelse($notifications as $notification)
                        <a href="/requests/{{$notification['data']['service_request_id']}}" class="list-group-item">
                            <strong>New request:</strong> {{$notification['data']['service_request_id']}}<br>
                            <em>submitted on </em> {{$notification->created_at}}
                        </a>
                    @empty
                        <p class="list-group-item"><em>There are no unread notifications at this time.</em></p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
