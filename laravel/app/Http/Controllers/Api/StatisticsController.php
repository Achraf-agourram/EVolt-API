<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalEnergy = Reservation::where('status', 'completed')->sum('energy_kwh');

        $totalReservations = Reservation::count();

        $reservationsPerStation = Reservation::select('station_id')->selectRaw('COUNT(*) as total_reservations')->groupBy('station_id')->get();

        $energyPerStation = Reservation::select('station_id')->selectRaw('SUM(energy_kwh) as total_energy')->where('status', 'completed')->groupBy('station_id')->get();

        return response()->json([
            'total_energy_delivered' => $totalEnergy,
            'total_reservations' => $totalReservations,
            'reservations_per_station' => $reservationsPerStation,
            'energy_per_station' => $energyPerStation
        ]);
    }
}
