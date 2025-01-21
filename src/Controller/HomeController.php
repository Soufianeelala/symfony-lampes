<?php

namespace App\Controller;

use App\Repository\LampRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_Home')]
    public function index(LampRepository $LampRepository): Response
    {

        $lastestLampeById = $LampRepository->findLastCubeId();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "lamps" => $lastestLampeById,
        ]);
    }
}
