@if($notification->unread())
    <li>
        <a href="{{url("requests/{$notification->data['service_request_id']}")}}">
            <strong>{{str_limit($notification->data['description'], 100)}}</strong><br>
            <small>{{\Carbon\Carbon::parse($notification->data['submitted_at']['date'])->diffForHumans()}}</small>
        </a>
    </li>
@else
    <li>
        <a href="{{url("requests/{$notification->data['service_request_id']}")}}">
            {{str_limit($notification->data['description'], 100)}}<br>
            <small>{{\Carbon\Carbon::parse($notification->data['submitted_at']['date'])->diffForHumans()}}</small>
        </a>
    </li>
@endif