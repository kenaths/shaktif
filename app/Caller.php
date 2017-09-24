<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{

    protected $fillable = ['first_name', 'last_name', 'email', 'address', 'city', 'nic', 'dob', 'gender', 'is_deleted','created_user_id'];


    public function phoneNumbers( $fields = array() )
    {
        if( !empty($fields) ){
            return $this->hasMany( PhoneNumber::class)->select( $fields );
        }
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

    public function programmeCount( $params = array() )
    {
        return $this->phoneNumbers( ['number','caller_id'] )->with(['callCount'=>function($q) use ($params) {

            if( !empty($params) && !$params['all'] ){

                $q->whereBetween('created_at',[$params['from'],$params['to']]);
            }

            $q->with(['programme' => function( $qu ){

                $qu->select(array('id','name'));

            }]);

        }])->get();
    }



}
