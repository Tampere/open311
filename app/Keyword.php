<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $fillable = ['name'];

    public function Services()
    {
        return $this->belongsToMany(Service::class, 'keyword_service', 'keyword_id', 'service_code');
    }
}
