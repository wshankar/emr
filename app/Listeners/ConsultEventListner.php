<?php

namespace App\Listeners;

use App\Events\ConsultEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConsultEventListner
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
     * @param  ConsultEvent  $event
     * @return void
     */
    public function handle(ConsultEvent $event)
    {
        //
    }
}
