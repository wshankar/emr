<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['prescription', 'fees', 'patient_id', 'follow_up'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

  
}
