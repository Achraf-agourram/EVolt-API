<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function book (Request $request)
    {
        $checkReservedStation = Reservation::where('station_id', $request->station_id)->where('status', '!=', 'cancelled')->whereBetween('start_time', [$request->start_time, $request->end_time])->orWhereBetween('end_time', [$request->start_time, $request->end_time])->exists();

        if ($checkReservedStation) return response()->json(['message' => 'This station is already reserved for this time period'], 403);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'station_id' => $request->station_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation
        ], 201);
    }
}
