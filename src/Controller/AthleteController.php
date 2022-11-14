<?php

namespace App\Controller;

use App\Repository\AthleteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/athlete", name="athlete")
 */
class AthleteController extends AbstractController
{
    /**
     * @Route("/", name="browse_athlete", methods={"GET"})
     */
    public function browse(AthleteRepository $athleteRepository): JsonResponse
    {
        $allAthletes = $athleteRepository->findAll();

        return $this->json($allAthletes, Response::HTTP_OK, [], ['groups' => 'api_athlete_browse']);
    }
}
