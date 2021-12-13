<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class WeatherController extends LocationController
{
    private $api_key='75644221927cf43372e9901b8ab3fce1';

    /**
     * @Route("/")
     */
    public function index() {
        $location = parent::getLocationWithCache();
        $city = $location['city'];

        $data = $this->getWeather($city);

        return new JsonResponse($data);
    }


    // Reloads data skipping cache
    /**
     * @Route("/fresh-data")
     */
    public function indexRefreshed() {
        $location = parent::getLocation();
        $city = $location['city'];

        $data = $this->getWeather($city);

        return new JsonResponse($data);
    }

    private function getWeather($city) {

        $client = HttpClient::create();
        $response = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$this->api_key");
        $response_content = $response->getContent();

        $data = json_decode($response_content);

        $formatted_response = FormatResponseController::formatWeatherResponse($data);

        return $formatted_response;
    }
}   