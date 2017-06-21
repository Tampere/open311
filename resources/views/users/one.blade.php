<div class="panel panel-default">
    <div class="panel-heading">{{$user->name}}</div>

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
                <th>Name:</th>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{$user->email}}</td>
            </tr>
            </tbody>
        </table>

        @unless($user->id == auth()->id())
            <form action="{{url('users/'.$user->id)}}" method="POST" class="form">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-danger">Delete user</button>
            </form>
        @endunless
    </div>
</div>
