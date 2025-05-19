<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ResetPasswordController extends AbstractController
{
    #[Route('/reset/password/{token}', name: 'app_reset_password')]
    public function index(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
       
    ): Response {
        // Requête DQL pour récupérer l'utilisateur correspondant au token
        $user = $userRepository->findOneBy(['resetToken' => $token]);

        if (!$user || !$user->isResetTokenValid()) {
            // Vérification si l'utilisateur n'existe pas ou si le token est invalide/expiré
            $this->addFlash('danger', 'Le lien de réinitialisation est invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password');
        }

        // Création du formulaire ResetPasswordType
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        // Traitement du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération et encodage du nouveau mot de passe
            $password = $form->get('plainPassword')->getData();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);

            // Réinitialisation des propriétés resetToken et resetTokenExpiresAt
            $user->setResetToken(null);
            $user->setResetTokenExpiresAt(null);

            // Sauvegarde dans la base de données
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
            return $this->redirectToRoute('app_login');
        }

        // Affichage du formulaire dans la vue Twig
        return $this->render('reset_password/resetpassword.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
