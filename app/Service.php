<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    Use Traits\Uuids;

    public $incrementing = false;

    public $primaryKey = 'service_code';
}
