<?php

namespace App\Customer;
use App\Trip\Trip;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'firstname', 'lastname','phone', 'email','address', 'photo'
    ];
    protected $guarded = ['image'];
    public function trips()
    {
        return $this->hasMany(Trip::class, 'email', 'email');
    }
   
}
