<?php



namespace App\Controller;

use App\Repository\LampRepository;
use Symfony\Component\HttpFoundation\Request; // Ajout de la classe Request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_Home')]
    public function index(Request $request, LampRepository $lampRepository): Response
    {
        // Récupérer les lampes les plus récentes par ID
        $lastestLampeById = $lampRepository->findLastCubeId();
    
        // Récupérer le paramètre 'filter' de la requête
        $filter = $request->query->get('filter');

        // Appliquer le filtre en fonction de la valeur
        if ($filter === 'date_desc') {
            // Trier par date décroissante
            $lamps = $lampRepository->findBy([], ['date' => 'DESC']);
        // } elseif ($filter === 'date_asc') {
        //     // Trier par date croissante
        //     $lamps = $lampRepository->findBy([], ['date' => 'ASC']);
        // } elseif ($filter === 'prix_desc') {
        //     // Trier par prix décroissant
        //     $lamps = $lampRepository->findBy([], ['price' => 'DESC']);
        // } elseif ($filter === 'prix_asc') {
        //     // Trier par prix croissant
        //     $lamps = $lampRepository->findBy([], ['price' => 'ASC']);
        } else {
            // Par défaut, pas de filtre appliqué
            $lamps = $lampRepository->findAll();
        }

        // Retourner la vue avec les résultats
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'lamps' => $lamps, // Remplacer par les lampes filtrées
            'lastestLampeById' => $lastestLampeById,
        ]);
    }
}
