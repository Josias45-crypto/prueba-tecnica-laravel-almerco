<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class LocationController extends Controller
{
    /**
     * Obtener estados por país
     */
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    /**
     * Obtener ciudades por estado
     */
    public function getCities($stateId)
    {
        $cities = \App\Models\City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }
}
