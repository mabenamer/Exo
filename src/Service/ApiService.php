<?php

namespace App\Service;

use GuzzleHttp\Client;

class ApiService
{
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'AIzaSyDSXC0jFd9yAPUdc1kT1_c_h39czvPTwmw';
    }

    public function fetchAirQualityData($latitude, $longitude): array
    {
        // Calculer la date de début 30 jours avant la date actuelle
        $startDate = new \DateTime();
        $startDate->modify('-30 days');
        $startTime = $startDate->format('Y-m-d\TH:i:s\Z');

        // Calculer la date de fin il y a 30 jours à partir de la date actuelle
        $endDate = new \DateTime();
        $endDate->modify('-1 days');
        $endTime = $endDate->format('Y-m-d\TH:i:s\Z');

        $response = $this->client->request('POST', 'https://airquality.googleapis.com/v1/history:lookup?key=' . $this->apiKey, [
            'json' => [
                'period' => [
                    'startTime' => $startTime,
                    'endTime' => $endTime
                ],
                
                'pageToken' => '',
                'location' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ]
            ]
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } else {
            throw new \Exception('Failed to fetch data from API: ' . $statusCode);
        }
    }
}
