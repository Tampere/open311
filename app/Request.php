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
}
