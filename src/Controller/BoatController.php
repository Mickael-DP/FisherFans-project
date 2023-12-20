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

            $brand = $request->get('brand');
            $description = $request->get('description');
            $manufacturingYear = $request->get('manufacturingYear');
            $name = $request->get('name');
            $photoURL = $request->get('photoURL');

            if (!$brand || !$description || !$manufacturingYear || !$name || !$photoURL) {
                return new Response('Toutes les données requises ne sont pas fournies.', Response::HTTP_BAD_REQUEST);
            }

            try {
                $boat = new Boat();

                $boat->setRequiredLicenseType($user->getBoatingLicenseNumber());

                $boat->setBrand($brand);
                $boat->setDescription($description);
                $boat->setManufacturingYear($manufacturingYear);
                $boat->setName($name);
                $boat->setPhotoURL($photoURL);

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
