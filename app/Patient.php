<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Patient extends Model
{
    protected $fillable= ['name','age','gender','address','phone'];

    protected $with = ['treatments'];


    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function getPathAttribute()
    {
        return "patient/$this->id";
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFollowupAttribute()
    {
        return $this->treatments()->latest('follow_up')->first('follow_up');
    }
}
