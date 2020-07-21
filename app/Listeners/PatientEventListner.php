<?php

namespace App\Listeners;

use App\Events\PatientEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PatientEventListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PatientEvent  $event
     * @return void
     */
    public function handle(PatientEvent $event)
    {
        //
    }
}
