<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactFormType;

final class ContacterController extends AbstractController
{
    #[Route('/contacter', name: 'app_contacter')]
    public function index(Request $request): Response
    {
        // Créer une instance du formulaire
        $contactForm = $this->createForm(ContactFormType::class);

        // Gérer la requête (nécessaire pour détecter si le formulaire a été soumis)
        $contactForm->handleRequest($request);

        // Vous pouvez ajouter une logique pour traiter les données soumises ici
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Traitez les données ici, comme envoyer un email ou sauvegarder en base
        }

        // Rendre la vue en passant le formulaire
        return $this->render('contacter/contacter.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
