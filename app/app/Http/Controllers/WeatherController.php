<?php

namespace App\Http\Controllers;

use App\Services\WeatherApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function location(Request $request)
    {
        $fields = [
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $fields);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); 
        }

        return response()->json((new WeatherApiService($request->lat, $request->long))->getData());
    }
}
