<tr>
    <td><input type="checkbox"></td>
    <td>{{$request->created_at->diffForHumans()}}</td>
    <td>{{$request->title}}</td>
    <td>{{str_limit($request->description)}}</td>
    <td>
        <span class="label {{$request->status === "pending" ? 'label-warning' : 'label-info'}}">
            {{$request->status}}
        </span>
    </td>
    <td>
        <a href="{{route('requests.show', $request)}}" class="btn btn-info btn-xs">Show request</a>
    </td>
</tr>
