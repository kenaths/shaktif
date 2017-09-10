<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{

    protected $fillable = ['number','caller_id','created_user_id','is_deleted'];

    public function caller()
    {
        return $this->belongsTo(Caller::class);
    }

}
