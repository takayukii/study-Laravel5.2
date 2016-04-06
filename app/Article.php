<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'published_at'];
    protected $dates = ['published_at'];

    public function getTitleAttribute($value)
    {
        return mb_strtoupper($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = mb_strtolower($value);
    }
}
