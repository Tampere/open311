<?php

namespace App;

use App\Filters\RequestFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use Traits\Uuids;
    use Traits\GeoLocateable;

    public $incrementing = false;

    public $primaryKey = 'service_request_id';

    protected $guarded = [];

    public function scopeFilter(Builder $query, RequestFilters $filters)
    {
        return $filters->apply($query);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_code');
    }

    public function photos()
    {
        return $this->hasMany(RequestPhoto::class, 'service_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLat()
    {
        if(is_null($this->location)) return null;

        return explode(',', $this->location)[0];
    }

    public function getLong()
    {
        if(is_null($this->location)) return null;

        return explode(',', $this->location)[1];
    }
}
