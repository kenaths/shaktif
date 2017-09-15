<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    protected $fillable = [
        'name', 'description', 'created_user_id', 'is_deleted'
    ];


    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch( $query, $search )
    {
        return $query->where(function($query) use ($search) {

            $query->where('name','LIKE',"%$search%");

        });
    }




}
