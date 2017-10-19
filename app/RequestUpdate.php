<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestUpdate extends Model
{
    protected $fillable = ['service_request_id', 'user_id', 'old_value', 'new_value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
