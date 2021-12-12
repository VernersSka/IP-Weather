<?php

namespace App\Controller;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class LocationController extends IPController
{
    public function __construct()
    {
        $this->ip = parent::getIp();
        $this->access_key = '93a1cd93c67dd2f1c32fc65fe9d7a726';
    }

    public function getLocation() {

        $cache = new FilesystemAdapter();

        $location = $cache->get($this->ip, function(ItemInterface $item) {

            echo "Not in cache <br>";

            $item->expiresAfter(3600); // 1 hour
            
            $client = HttpClient::create();
            $response = $client->request('GET', "http://api.ipstack.com/$this->ip?access_key=$this->access_key");
            $response_content = $response->getContent();
    
            $data = json_decode($response_content);
    
            $formatted_response = FormatResponseController::formatLocationResponse($data);

            return $formatted_response;
        });
      
        return $location;
    }

}