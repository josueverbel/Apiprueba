<?php

namespace App\Trip;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'email', 'country','city', 'dateofservice',
    ];
    
}
