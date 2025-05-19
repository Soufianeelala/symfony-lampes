<?php

namespace App\Controller;

use App\Entity\Lamp;
use App\Repository\LampRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GalerieController extends AbstractController
{
    #[Route('/galerie', name: 'app_galerie')]
    public function index(LampRepository $lampRepository, Request $request): Response
    {
        // Récupérer toutes les lampes depuis la base de données
        $lamps = $lampRepository->findAll();
        $filter = $request->query->get('filter', 'default');
       // $logger->info('Filtre sélectionné : ' . $filter);
    
        switch ($filter) {
            case 'date_desc':
                $lamps = $lampRepository->date_desc(10);
                break;
    
            case 'prix_asc':
                $lamps = $lampRepository->prix_asc();
                break;
    
            default:
                $lamps = $lampRepository->findLastCubeId(10);
                break;
        }
        // Passer les lampes à la vue
        return $this->render('galerie/galerie.html.twig', [
            'lamps' => $lamps, // Passez les lampes récupérées à la vue
        ]);
    }
}

