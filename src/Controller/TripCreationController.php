<?php

namespace App\Controller;

use App\Entity\FishingTrip;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TripCreationController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (count($user->getBoats()) < 1) {
            return $this->json(["message" => "User needs a boat to create a fishing trip"], 403);
        }

        $data = json_decode($request->getContent(), true);
        $trip = new FishingTrip();

        try {
            $trip->setTitle($data["title"])
                ->setInformations($data["informations"])
                ->setType($data["type"])
                ->setRate($data["rate"])
                ->setStartingDate(new \DateTime($data["startingDate"]))
                ->setStartingTime(new \DateTime($data["startingTime"]))
                ->setEndingDate(new \DateTime($data["endingDate"]))
                ->setEndingTime(new \DateTime($data["endingTime"]))
                ->setPassengerNumber($data["passengerNumber"])
                ->setPrice($data["price"])
                ->setOwner($user);
            $em = $this->doctrine->getManager();
            $em->persist($trip);
            $em->flush();

            return $this->json($trip, 201);
        } catch (Exception $e) {
            return $this->json("Bad Request", 400);
        }

    }
}
