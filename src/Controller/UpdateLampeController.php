<?php

namespace App\Controller;

use App\Entity\Lamp;
use App\Form\FormLampType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateLampeController extends AbstractController
{
    #[Route('/update/lampe/{id}', name: 'app_update_lampe')]
    public function index(Lamp $lamp, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // Vérifie si l'utilisateur connecté est le créateur de la lampe ou un administrateur
        if ($lamp->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            // Ajout d'un message d'alerte pour l'utilisateur
            $this->addFlash('alert', "Vous n'êtes pas autorisé à modifier cette lampe.");

            // Redirection vers la page d'accueil ou une autre page
            return $this->redirectToRoute('app_Home');
        }

        // Création du formulaire lié à la lampe
        $form = $this->createForm(FormLampType::class, $lamp);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde de la lampe
            $entityManager->persist($lamp);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Lampe modifiée avec succès.');

            // Redirection après la modification
            return $this->redirectToRoute('app_Home');
        }

        // Rendu du formulaire
        return $this->render('update_lampe/update.html.twig', [
            'lampeform' => $form->createView(),
            'lamp' => $lamp,
        ]);
    }
}
