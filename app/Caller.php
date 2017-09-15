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

    public function callerNotes()
    {

        return $this->hasMany( CallerNote::class);

    }

    public function scopeSearch( $query, $search )
    {
        return $query->where(function($query) use ($search) {

            $query->where('first_name','LIKE',"%$search%")
                ->orWhere('last_name','LIKE',"%$search%");

        });
    }



}
