<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Patient extends Model
{
    protected $fillable= ['name','age','gender','address','phone','fatherName'];

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
}
