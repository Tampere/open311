<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $incrementing = false;

    public $primaryKey = 'service_code';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = ['metadata' => 'boolean'];

    protected $appends = ['keywords'];

    //protected $with = ['keywords'];

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'keyword_service', 'service_code');
    }

    public function getKeywordsAttribute()
    {
        return $this->attributes['keywords'] = implode(',', $this->keywords()->pluck('name')->toArray());
    }
}
