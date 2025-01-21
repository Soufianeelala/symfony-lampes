<?php

namespace App\Controller;

use App\Entity\Lamp;
use App\Form\FormLampType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateLampeController extends AbstractController
{
    #[Route('/update/lampe/{id}', name: 'app_update_lampe' )]
    public function index(Lamp $lamp, Request $request, EntityManagerInterface $entityManager): Response
    {

         // 2. Création d'un formulaire basé sur l'entité Lamp et lié à $lamp
         $form = $this->createForm(FormLampType::class, $lamp);

         // 3. Traitement des données soumises via la requête HTTP (POST)
         $form->handleRequest($request);
 
         // 4. Vérification si le formulaire a été soumis et validé (tous les champs remplis correctement)
         if ($form->isSubmitted() && $form->isValid()) {
             // a. Persiste l'objet $lamp (prépare l'entité pour la sauvegarde en base de données)
             $entityManager->persist($lamp);
 
             // b. Exécute la sauvegarde (insère ou met à jour l'entité dans la base de données)
             $entityManager->flush();
 
             // c. Ajoute un message flash pour informer l'utilisateur du succès de l'opération
             $this->addFlash('success', 'Lampe Modifier avec succès');
 
             // d. Redirige l'utilisateur vers une autre page définie par la route "app_Home"
             return $this->redirectToRoute('app_Home');
         }

        return $this->render('update_lampe/update.html.twig', [
            'lampeform' => $form->createView(),
            'lamp' => $lamp,  

        ]);
    }
}
