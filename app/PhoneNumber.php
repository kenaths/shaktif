<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{

    public function caller()
    {
        return $this->belongsTo(Caller::class);
    }
}
