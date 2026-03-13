<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\Station;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StartChargingJob implements ShouldQueue
{
    use Queueable;
    protected $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    
    public function handle(): void
    {
        $reservation = Reservation::find($this->reservation->id);

        if (!$reservation) return;

        $reservation->update(['status' => 'charging']);

        $station = Station::find($reservation->station_id);

        if ($station) $station->update(['is_available' => false]);
    }
}
