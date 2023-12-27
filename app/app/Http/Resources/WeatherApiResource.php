<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lat' => $this->resource->location['lat'],
            'long' => $this->resource->location['lon'],
            'timezone' =>$this->resource->location['tz_id'],
            'current_weather' => [
                'datetime' => $this->current['last_updated'],
                'temp' => $this->current['temp_c'],
                'feels_like' => $this->current['feelslike_c']
            ],
            'daily_forecast' => [
                'datetime' => $this->forecast['forecastday'][0]['date'],
                'sunrise' => $this->forecast['forecastday'][0]['astro']['sunrise'],
                'sunset' => $this->forecast['forecastday'][0]['astro']['sunset'],
                'summary' => $this->forecast['forecastday'][0]['day']['condition']['text'],
                'temp' => [
                    'day' =>  $this->forecast['forecastday'][0]['day']['avgtemp_c'],
                    'min' => $this->forecast['forecastday'][0]['day']['mintemp_c'],
                    'max' => $this->forecast['forecastday'][0]['day']['maxtemp_c'],
                    'night' => $this->forecast['forecastday'][0]['day']['mintemp_c'],
                    'evening' => $this->forecast['forecastday'][0]['day']['maxtemp_c'],
                    'morning' => $this->forecast['forecastday'][0]['day']['avgtemp_c']
                ]
            ]
        ];
    }
}
