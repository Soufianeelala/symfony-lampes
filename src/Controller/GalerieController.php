<?php

namespace App\Controller;

use App\Entity\Lamp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GalerieController extends AbstractController
{
    #[Route('/galerie', name: 'app_galerie')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les lampes depuis la base de données
        $lamps = $entityManager->getRepository(Lamp::class)->findAll();

        // Passer les lampes à la vue
        return $this->render('galerie/galerie.html.twig', [
            'lamps' => $lamps, // Passez les lampes récupérées à la vue
        ]);
    }
}

