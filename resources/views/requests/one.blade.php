<div class="panel {{$class}}">
    <div class="panel-heading">
        <h3 class="panel-title">
            <a href="{{url('requests/' . $request->service_request_id)}}">
                {{$request->service_request_id}}
            </a>
            <small>submitted {{$request->created_at->diffForHumans() }}</small>

            <span style="display: flex;" class="pull-right">
                @unless($request->status == 'closed')
                    <form class="form" action="{{url('requests/' . $request->service_request_id)}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <button type="submit" class="btn btn-xs btn-primary" title="Mark service request as closed"><i class="glyphicon glyphicon-check"></i></button>
                    </form>
                @endunless
                <form class="form" action="{{url('requests/' . $request->service_request_id)}}" method="POST">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
                </form>
            </span>
        </h3>
    </div>

    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">Service request id</th>
                <td>
                    <a href="{{url('requests/' . $request->service_request_id)}}">
                        {{$request->service_request_id}}
                    </a>
                </td>
            </tr>
            <tr>
                <th scope="row">Status</th>
                <td>{{$request->status}}</td>
            </tr>
            <tr>
                <th scope="row">Service name</th>
                <td>{{$request->service->service_name}}</td>
            </tr>
            <tr>
                <th scope="row">Agency responsible</th>
                <td>{{$request->agency_responsible}}</td>
            </tr>
            <tr>
                <th scope="row">Description</th>
                <td>{{$request->description}}</td>
            </tr>
            <tr>
                <th scope="row">Title</th>
                <td>{{$request->title}}</td>
            </tr>
            <tr>
                <th scope="row">Location</th>
                <td><strong>Address: </strong>{{$request->address_string}} <strong>Zip: </strong>{{$request->zip_code}} <strong>Geo: </strong>{{$request->location}}</td>
            </tr>
            <tr>
                <th scope="row">Submitted by</th>
                <td><strong>Name: </strong>{{$request->first_name}} {{$request->last_name}} <strong>Email: </strong>{{$request->email}} <strong>Phone: </strong>{{$request->phone}}</td>
            </tr>
            <tr>
                <th scope="row">Media url</th>
                <td>{{$request->media_url}}</td>
            </tr>
            <tr>
                <th scope="row">Media urls</th>
                <td>
                    @if($request->photos)
                        @foreach($request->photos as $photo)
                            <img src="{{asset('storage/'.$photo->filename)}}" alt="{{$photo->filename}}" width="150">
                        @endforeach
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>