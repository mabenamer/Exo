<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ApiService;

class AirqualityController extends AbstractController
{
    private $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @Route("/airquality", name="app_airquality")
     */
    public function index(Request $request): Response
    {
        // Liste des localités avec leurs coordonnées
        $localities = [
            'Paris' => ['latitude' => 48.864716, 'longitude' => 2.349014],
            'New-York' => ['latitude' => 40.730610, 'longitude' => -73.935242] 
        ];

       // Récupérer la localité sélectionnée à partir des paramètres de l'URL
       $selectedLocality = $request->query->get('locality', key($localities));

        $coords = $localities[$selectedLocality];
        $latitude = $coords['latitude'];
        $longitude = $coords['longitude'];

        // Récupérer les données d'indice de qualité de l'air en fonction des nouvelles coordonnées
        $airQualityData = $this->apiService->fetchAirQualityData($latitude, $longitude);

        return $this->render('airquality/index.html.twig', [
            'data' => $airQualityData,
            'localities' => $localities,
            'selectedLocality' => $selectedLocality,
        ]);
    }
}
