<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallerNote extends Model
{
    public function user()
    {
        return $this->hasOne(User::class,'id','created_user_id')
            ->select(array('id', 'name'));
    }
}
