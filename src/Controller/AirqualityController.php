<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AirqualityController extends AbstractController
{
    /**
     * @Route("/airquality", name="app_airquality")
     */
    public function index(Request $request): Response
    {
        // Clé API
       // $apiKey = 'AIzaSyDSXC0jFd9yAPUdc1kT1_c_h39czvPTwmw';

        // URL de l'API Air Quality de Google
       // $url = 'https://airquality.googleapis.com/v1/history:lookup?key=' . $apiKey;



        // Liste des localités avec leurs latitudes et longitudes
        $localities = [
            'Paris' => '48.864716, 2.349014',
            'New York' => '40.730610, -73.935242' 
        ];

        // Récupérer la localité sélectionnée (par défaut ou lors d'un changement)
        $selectedLocality = $request->query->get('locality', key($localities)); 

      
        // Données de la requête
       /* $data = [

            'pageSize' => 30,
            'location' => [
                'latitude' => 40.7128,
                'longitude' => -74.0060
            ],
            'hours' => 24,
            'universalAqi' => true,
            'languageCode' => 'fr'
        ];

        // Configuration de l'HttpClient
        $client = HttpClient::create();
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $data,
        ]);

        // Récupération des données JSON
        $airQualityData = $response->toArray();
        */
        return $this->render('airquality/index.html.twig', [
           // 'air_quality_data' => $airQualityData,
            'localities' => $localities,
            'selectedLocality' => $selectedLocality,
        ]);
    }
}
