<?php

namespace App\Services;
use GuzzleHttp\Client;
use App\Http\Resources\WeatherApiResource;

class WeatherApiService {

    public $lat;
    public $long;

    public function __construct(float $lat, float $long) {
        $this->lat = $lat;
        $this->long = $long;
    }

    public function getData()
    {
        $client = new Client();

        try {
            $response = $client->get('http://api.weatherapi.com/v1/forecast.json', [
                'query' => [
                    'q' => $this->lat . ',' . $this->long,
                    'days' => 1,
                    'aqi' => 'no',
                    'alerts' => 'no',
                    'key' => config('app.weather_api_key')
                ]
            ]); 

            $data = $response->getBody()->getContents();

            $data = (object) json_decode($data, true);

            return new WeatherApiResource($data);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], $e->getCode());
        }
    }
}