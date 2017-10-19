<?php

namespace App\Listeners;

use App\Events\RequestStatusUpdated;
use App\Mail\RequestStatusChangedNotification;
use App\Mail\RequestStatusChangeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyRequestSender
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RequestStatusUpdated  $event
     * @return void
     */
    public function handle(RequestStatusUpdated $event)
    {
        if(is_null($event->request->email)) return;

        Mail::to($event->request->email)
            ->send(new RequestStatusChangeNotification($event->request));
    }
}
