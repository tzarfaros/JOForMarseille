<?php

namespace App\Controller;

use App\Repository\AthleteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @Route("/searchBy", name="searchBy" , methods={"GET"} )
     */
    public function searchBy(AthleteRepository $athleteRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $gender = $request->query->get('gender');
        $nationality = $request->query->get('nationality');
        $epreuves = $request->query->get('epreuves');

        $ListAthletes = $athleteRepository->findAthletesByFilters($gender , $nationality, $epreuves);
        var_dump($ListAthletes);

        $nbrAthlete = 0;

        foreach($ListAthletes as $currentAthlete) {
            $nbrAthlete += 1;
        }

        /* $ListAthletes = $paginator->paginate (
            $ListAthletes,
            $request->query->getInt ('page' , 1 ),
            15
        ); */

        $data = [
            'nbr_athletes' => $nbrAthlete,
            'list' => $ListAthletes
        ];

        return $this->json($data, Response::HTTP_OK, [], ['groups' => 'api_athlete_browse']);
    }

    /**
     * @Route("/like/{idAthlete}/{idUser}", name="editLike", methods={"PATCH"}, requirements={"idAthlete"="\d+"})
     */
    public function editLike(ValidatorInterface $validator, $idAthlete, $idUser, AthleteRepository $athleteRepository, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $athlete = $athleteRepository->find($idAthlete);
        $currentUser = $userRepository->find($idUser);
        $currentUser->addAthlete($athlete);
        
        if (is_null($currentUser)) {
            return $this->getNotFoundResponse();
        }

        if (is_null($athlete)) {
            return $this->getNotFoundResponse();
        }

        $errors = $validator->validate($athlete);

        if(count($errors) > 0)
        {
            $reponseAsArray = [
                'error' => true,
                'message' => $errors,
            ];

            return $this->json($reponseAsArray, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->flush();

        $reponseAsArray = [
            'message' => 'Athlète ajouté dans les favoris.',
            'id' => $athlete->getId()
        ];

        return $this->json($reponseAsArray, Response::HTTP_CREATED);
    }

    /**
     * @Route("/dislike/{idAthlete}/{idUser}", name="editDislike", methods={"PATCH"}, requirements={"idAthlete"="\d+"})
     */
    public function editDislike(ValidatorInterface $validator, int $idAthlete, $idUser, AthleteRepository $athleteRepository, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $athlete = $athleteRepository->find($idAthlete);
        $currentUser = $userRepository->find($idUser);
        $currentUser->removeAthlete($athlete);
        
        if (is_null($currentUser)) {
            return $this->getNotFoundResponse();
        }

        if (is_null($athlete)) {
            return $this->getNotFoundResponse();
        }
        
        $errors = $validator->validate($athlete);

        if(count($errors) > 0)
        {
            $reponseAsArray = [
                'error' => true,
                'message' => $errors,
            ];

            return $this->json($reponseAsArray, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->flush();

        $reponseAsArray = [
            'message' => 'Athlète supprimé des favoris.',
            'id' => $athlete->getId()
        ];

        return $this->json($reponseAsArray, Response::HTTP_CREATED);
    }

    private function getNotFoundResponse() {

        $responseArray = [
            'error' => true,
            'userMessage' => 'Ressource non trouvée',
            'internalMessage' => 'Cet athlète n\'existe pas dans la BDD',
        ];

        return $this->json($responseArray, Response::HTTP_UNPROCESSABLE_ENTITY);
    }


}
