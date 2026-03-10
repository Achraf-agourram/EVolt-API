<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalEnergy = Reservation::where('status', 'completed')->sum('energy_kwh');

        $totalReservations = Reservation::count();

        
    }
}
