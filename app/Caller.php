<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{

    protected $fillable = ['first_name', 'last_name', 'email', 'address', 'city', 'nic', 'dob', 'gender', 'is_deleted','created_user_id'];


    public function phoneNumbers()
    {

        return $this->hasMany( PhoneNumber::class);

    }



}
