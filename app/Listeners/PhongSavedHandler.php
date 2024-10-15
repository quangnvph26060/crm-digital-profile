<?php

namespace App\Listeners;

use App\Events\PhongSaved;
use Illuminate\Contracts\Queue\ShouldQueue;

class PhongSavedHandler implements ShouldQueue
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
     * @param  PhongSaved  $event
     * @return void
     */
    public function handle(PhongSaved $event)
    {
        // Xử lý logic khi sự kiện xảy ra
    }
}