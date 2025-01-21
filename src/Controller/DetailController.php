<?php

namespace App\Controller;

use App\Entity\Lamp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DetailController extends AbstractController
{
   
    #[Route('/galerie/{id}', name: 'app_detail')]
    public function detail(int $id, EntityManagerInterface $entityManager): Response
    {
        // Trouver la lampe par ID
        $lamp = $entityManager->getRepository(Lamp::class)->find($id);
    
        // Si aucune lampe n'est trouvée, lancer une exception
        if (!$lamp) {
            throw $this->createNotFoundException("La lampe avec l'ID $id n'existe pas.");
        }
    
        // Envoyer uniquement cette lampe à la vue
        return $this->render('detail/detail.html.twig', [
            'lamp' => $lamp, // Une seule lampe
        ]);
    }
    
}