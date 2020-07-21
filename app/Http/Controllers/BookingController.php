<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Events\BookingEvent;
use App\Events\ConsultEvent;
use App\Http\Resources\BookingResource;
use App\Notifications\BookingNoti;
use App\Patient;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookedPatient()
    {
        return BookingResource::collection(Booking::all());
    }

    public function booked($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->booking()->create();
        broadcast(new BookingEvent($patient));
    }

 
    public function destroy(Patient $patient)
    {
        $patient->booking()->first()->delete();
        broadcast(new ConsultEvent($patient));
    }
}
