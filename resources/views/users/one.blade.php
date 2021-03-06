<div class="panel panel-default">
    <div class="panel-heading">{{$user->name}}</div>

    <div class="panel-body">
        <table class="table">
            <thead>
            <tr>
                <th>Avain</th>
                <th>Arvo</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Nimi:</th>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{$user->email}}</td>
            </tr>
            </tbody>
        </table>

        @if($user->admin)
            <form action="{{url('users/'.$user->id).'/admin'}}" method="POST" class="form">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-danger">Poista pääkäyttäjästatus</button>
            </form>
        @else
            <form action="{{url('users/'.$user->id).'/admin'}}" method="POST" class="form">
                {{csrf_field()}}
                <button type="submit" class="btn btn-success">Lisää pääkäyttäjästatus</button>
            </form>
        @endif

        @unless($user->id == auth()->id())
            <form action="{{url('users/'.$user->id)}}" method="POST" class="form">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-danger">Poista käyttäjä</button>
            </form>
        @endunless
    </div>
</div>
