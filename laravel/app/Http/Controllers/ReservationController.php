<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function book (Request $request)
    {
        $checkReservedStations = Reservation::where('station_id', $request->station_id)->where('status', '!=', 'cancelled')->whereBetween('start_time', [$request->start_time, $request->end_time])->orWhereBetween('end_time', [$request->start_time, $request->end_time])->exists();

        if ($checkReservedStations) return response()->json(['message' => 'This station is already reserved for this time period'], 403);

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

    public function cancel ($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($reservation->status === 'completed') {
            return response()->json([
                'message' => 'Completed reservations cannot be cancelled'
            ], 403);
        }

        if (now()->greaterThanOrEqualTo($reservation->start_time)) {
            return response()->json([
                'message' => 'Cannot cancel a reservation that already started'
            ], 403);
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        return response()->json([
            'message' => 'Reservation cancelled successfully',
            'reservation' => $reservation
        ]);
    }

    public function update (UpdateReservationRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $checkReservedStations = Reservation::where('station_id', $request->station_id)->where('id', '!=', $reservation->id)->where('status', '!=', 'cancelled')->whereBetween('start_time', [$request->start_time, $request->end_time])->orWhereBetween('end_time', [$request->start_time, $request->end_time])->exists();

        if ($checkReservedStations) return response()->json(['message' => 'This station is already reserved for this time period'], 403);

        $reservation->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);

        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation
        ]);
    }
}
