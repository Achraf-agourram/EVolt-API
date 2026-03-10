<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStationRequest;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function search (Request $request)
    {
        $query = Station::with('connectorType');

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $stations = $query->where('is_available', true)->get();

        return response()->json($stations);
    }

    public function store (StoreStationRequest $request)
    {
        
    }
}
