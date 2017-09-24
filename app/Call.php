<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = ['phone_number','user_id','end_at','is_deleted','programme_id'];

    public function phone()
    {
        return $this->hasOne(PhoneNumber::class,'number','phone_number');
    }

    public function operator()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

}
