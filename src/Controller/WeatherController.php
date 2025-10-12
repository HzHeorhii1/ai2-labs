<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather_city')]
    public function city(
        string $city,
        LocationRepository $locationRepository,
        MeasurementRepository $repository
    ): Response {
        $parts = explode(',', $city);
        $cityName = trim($parts[0]);
        $countryCode = isset($parts[1]) ? strtoupper(trim($parts[1])) : null;

        $location = $locationRepository->findByCityAndCountry($cityName, $countryCode);

        if (!$location) {
            throw new NotFoundHttpException("Nie znaleziono lokalizacji: $cityName");
        }

        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
