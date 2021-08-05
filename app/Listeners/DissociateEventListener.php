<?php

namespace App\Listeners;

use App\Events\DissociateEvent;
use App\Jobs\DissociateJob;
use Illuminate\Support\Facades\Log;

class DissociateEventListener
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
     * @param  DissociateEvent  $event
     * @return void
     */
    public function handle(DissociateEvent $event)
    {
        dispatch(new DissociateJob());
        Log::info('--------Event Listening------');
    }
}
