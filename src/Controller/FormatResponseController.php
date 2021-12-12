<?php

namespace App\Controller;

class FormatResponseController
{
    public static function formatWeatherResponse($data) {

        $response = [
            "country" => $data->sys->country,
            "city" => $data->name,
            "weather description" => $data->weather['0']->description,
            "temperature C" => $data->main->temp,
            "wind speed" => $data->wind->speed,
            "humidity" => $data->main->humidity,
            "pressure" => $data->main->pressure,
            "cloudiness" => $data->clouds->all
        ];

        return $response;
    }

    public static function formatLocationResponse($data) {

        $response = [
            "country" => $data->country_code,
            "city" => $data->city
        ];

        return $response;
    }
}