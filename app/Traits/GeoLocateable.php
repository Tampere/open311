<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait GeoLocateable
{
    protected $spatialFields = array('location');

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = $value ? DB::raw("POINT($value)") : null;
    }

    public function getLocationAttribute($value)
    {
        if(is_null($value)) {
            return null;
        }

        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);

        return substr($loc,0,-1);
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw = '';
        foreach($this->spatialFields as $column){
            $raw .= ' astext('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
    }

    public function scopeDistance(Builder $query, $distance, $location)
    {
        return $query->whereRaw('st_distance(location,POINT('.$location.')) < '.$distance);
    }
}