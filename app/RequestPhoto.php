<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPhoto extends Model
{
    protected $fillable = ['service_request_id', 'filename'];

    public function request()
    {
        return $this->belongsTo(Request::class, 'service_request_id');
    }
}
