<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'address',
        'address_exstra',
        'country',
        'city',
        'state',
        'postal_code',
        'latitude',
        'longitude',
    ];

    protected $dates = ['deleted_at'];
}
