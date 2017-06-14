<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use Traits\Uuids;
    use Traits\GeoLocateable;

    public $incrementing = false;

    public $primaryKey = 'service_request_id';

    protected $guarded = [];
}
