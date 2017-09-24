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

    public function calls()
    {
        return $this->hasMany(Call::class,'phone_number','number');
    }

    public function callCount()
    {
        //return $this->calls();
        return $this->calls()
            ->selectRaw('phone_number, programme_id, count(*) as aggregate')
            ->groupBy('phone_number','programme_id');
    }


}
