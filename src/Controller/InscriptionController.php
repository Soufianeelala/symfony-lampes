<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder
    ): Response {
        
        // Création d'un nouvel utilisateur
        $user = new User();

        // Création du formulaire
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification des mots de passe
            $plainPassword = $form->get('Password')->getData();

            // Hachage et attribution du mot de passe à l'utilisateur
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $plainPassword
                )
            );

            // Ajout du rôle utilisateur par défaut
            $user->setRoles(['ROLE_USER']);

            // Sauvegarde en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Message de confirmation
            $this->addFlash('success', 'Utilisateur enregistré avec succès !');

            // Redirection vers la page d'accueil ou une autre page
            return $this->redirectToRoute('app_Home');
        }

        return $this->render('inscription/inscription.html.twig', [
            'registrationForm' => $form->createView(), // La variable 'form' est définie ici
        ]);
        
    }
}
