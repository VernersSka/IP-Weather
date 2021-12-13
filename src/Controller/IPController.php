<?php

namespace App\Controller;

class IPController
{
    protected function getIp() {
        // uncomment when hosted on a server
        // $ip = $_SERVER['REMOTE_ADDR'];

        // test cases for localhost
        $ip = '122.100.149.65';
        // $ip = '73.177.121.07';
        // $ip = '43.87.119.85';

        return $ip;
    }
}