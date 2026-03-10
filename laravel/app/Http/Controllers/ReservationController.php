<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function book (Request $request)
    {
        $checkReservedStation = Reservation::where('station_id', $request->station_id)->where('status', '!=', 'cancelled')->whereBetween('start_time', [$request->start_time, $request->end_time])->orWhereBetween('end_time', [$request->start_time, $request->end_time]);

        if ($checkReservedStation) return response()->json(['message' => 'This station is already reserved for this time period'], 403);

        
    }
}
