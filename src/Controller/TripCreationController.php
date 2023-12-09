<?php

namespace App\Controller;

use App\Entity\FishingTrip;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
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
        $form = $this->createForm(FishingTrip::class, $trip);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->persist($trip);
            $em->flush();

            return $this->json($data, 201);
        }

        return $this->json("Bad Request", 400);
    }
}
