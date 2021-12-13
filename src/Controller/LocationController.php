<?php

namespace App\Controller;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class LocationController extends IPController
{
    private $ip;
    private $access_key;

    public function __construct()
    {
        $this->ip = parent::getIp();
        $this->access_key = '93a1cd93c67dd2f1c32fc65fe9d7a726';
    }

    public function getLocationWithCache() {
        $cache = new FilesystemAdapter();

        $location = $cache->get($this->ip, function(ItemInterface $item) {

            // echo "IP not cached" . PHP_EOL;

            $item->expiresAfter(3600);

            return $this->getLocation();
        });

        return $location;
    }

    public function getLocation() {
        $client = HttpClient::create();
        $response = $client->request('GET', "http://api.ipstack.com/$this->ip?access_key=$this->access_key");
        $response_content = $response->getContent();

        $data = json_decode($response_content);

        $formatted_response = FormatResponseController::formatLocationResponse($data);
        
        return $formatted_response;
    }

}