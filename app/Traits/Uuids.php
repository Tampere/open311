<?php

namespace App\Traits;

use App\User;
use Webpatser\Uuid\Uuid;

trait Uuids
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function($request) {
            foreach(User::all() as $user) {
                $user
                    ->notifications()
                    ->where('data->service_request_id', $request->service_request_id)
                    ->delete();
            }
        });
    }
}