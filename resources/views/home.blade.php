@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Palautteiden hallinta</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Odottavat</h3>
                            <hr>
                            <p><strong>Määrä: </strong>{{$pending->count()}}</p>
                            <p>
                                @if($pending->count() > 0)
                                    <ul>
                                        @foreach($pending->take(5) as $item)
                                            <li><a href="/requests/{{$item->service_request_id}}">{{str_limit($item->description, 100)}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Avoimet</h3>
                            <hr>
                            <p><strong>Määrä: </strong>{{$open->count()}}</p>
                            <p>
                            @if($open->count() > 0)
                                <ul>
                                    @foreach($open->take(5) as $item)
                                        <li><a href="/requests/{{$item->service_request_id}}">{{str_limit($item->description, 100)}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                                </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Suljetut</h3>
                            <hr>
                            <p><strong>Määrä: </strong>{{$closed->count()}}</p>
                            <p>
                            @if($closed->count() > 0)
                                <ul>
                                    @foreach($closed->take(5) as $item)
                                        <li><a href="/requests/{{$item->service_request_id}}">{{str_limit($item->description, 100)}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                                </p>
                        </div>
                        <div class="col-md-3">
                            <h3>Palauteosuudet</h3>
                            <hr>
                            <chart-renderer :data="{{json_encode($data)}}" :options="{}"></chart-renderer>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Ilmoitukset</div>

                <div class="panel-body">
                    <div class="list-group">
                    @forelse($notifications as $notification)
                        <a href="/requests/{{$notification['data']['service_request_id']}}" class="list-group-item">
                            <strong>Uusi palaute:</strong> {{str_limit($notification['data']['description'], 100)}}<br>
                            <em>lähetetty </em> {{$notification->created_at}}
                        </a>
                    @empty
                        <p class="list-group-item"><em>Ei lukemattomia ilmoituksia.</em></p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
