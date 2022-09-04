<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'image', 'title','description','duration','date'
    ];


    public function scopeSelection($query)
    {
        return $query->select('id', 'name_' . app()->getLocale() . ' as name');
    }
}
