<?php

namespace App\Controller;

use App\Entity\Boat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoatController extends AbstractController
{

    #[Route('/boats', name: 'create_boat', methods: ['POST'])]
    public function createBoat(Request $request): Response
    {
        $user = $this->getUser();

        if ($user && $user->getBoatingLicenseNumber() !== null) {

            $entityManager = $this->getDoctrine()->getManager();

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

                return new Response('Bateau créé avec succès', Response::HTTP_CREATED);
            } catch (\Exception $e) {
                return new Response('Erreur lors de la création du bateau : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return new Response('Vous devez indiquer un numéro de permis bateau pour créer un bateau.', Response::HTTP_FORBIDDEN);
        }
    }


}
