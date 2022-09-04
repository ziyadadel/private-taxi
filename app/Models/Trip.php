<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trips';

    protected $fillable = [
        'trip_num',
        'trip_name',
        'sedan_option',
        'van_option',
        'image',
        'show',
    ];


    public function scopeSelection($query)
    {
        return $query->select('id', 'name_' . app()->getLocale() . ' as name');
    }
}
