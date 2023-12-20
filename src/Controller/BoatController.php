<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoatController extends AbstractController
{


    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user && $user->getBoatingLicenseNumber() !== null) {

            $entityManager = $this->doctrine->getManager();

            $data = json_decode($request->getContent(), true);

            $brand = $data["brand"];
            $description = $data["description"];
            $manufacturingYear = $data["manufacturingYear"];
            $name = $data["name"];
            $type = $data["boatType"];
            $deposit = $data["depositAmount"];
            $photoURL = $data["photoURL"];
            $capacity = $data["maxCapacity"];
            $propulsionType = $data["propulsionType"];
            $size = $data["size"];

            try {
                $boat = new Boat();

                $boat->setRequiredLicenseType($user->getBoatingLicenseNumber());

                $boat->setBrand($brand);
                $boat->setDescription($description);
                $boat->setManufacturingYear($manufacturingYear);
                $boat->setName($name);
                $boat->setPhotoURL($photoURL);
                $boat->setBoatType($type);
                $boat->setDepositAmount($deposit);
                $boat->setMaxCapacity($capacity);
                $boat->setPropulsionType($propulsionType);
                $boat->setSize($size);
                $boat->setOwner($user);

                $entityManager->persist($boat);
                $entityManager->flush();

                return $this->json($boat, 201);
            } catch (\Exception $e) {
                return new Response('Erreur lors de la création du bateau : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return new Response('Vous devez indiquer un numéro de permis bateau pour créer un bateau.', Response::HTTP_FORBIDDEN);
        }
    }


}
