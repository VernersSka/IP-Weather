<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class WeatherController extends LocationController
{
    /**
     * @Route("/")
     */
    public function index() {
        $location = parent::getLocation();
        $city = $location['city'];

        $api_key='75644221927cf43372e9901b8ab3fce1';

        $client = HttpClient::create();
        $response = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$api_key");
        $response_content = $response->getContent();

        $data = json_decode($response_content);

        $formatted_response = FormatResponseController::formatWeatherResponse($data);

        return new JsonResponse($formatted_response);
    }
    
}