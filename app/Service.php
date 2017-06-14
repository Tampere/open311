<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $incrementing = false;

    public $primaryKey = 'service_code';

    protected $guarded = [];

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'keyword_service', 'service_code');
    }
}
