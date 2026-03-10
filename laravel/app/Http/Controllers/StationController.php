<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStationRequest;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->role !== 'admin') return response()->json(['message' => 'Unauthorized'], 403);

        $station = Station::create([
            'name' => $request->name,
            'city' => $request->city,
            'location' => $request->location,
            'power' => $request->power,
            'connector_type_id' => $request->connector_type_id
        ]);

        return response()->json(['message' => 'Station created successfully'], 201);
    }
}
