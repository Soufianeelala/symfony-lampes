<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;

final class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot/password', name: 'app_forgot_password')]
    public function index(
        Request $request,
        MailerInterface $mailer,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Création du formulaire ForgotPasswordType
        $form = $this->createForm(ForgotPasswordType::class);//creation du formulaire
        $form->handleRequest($request);//Recupiration de la requete

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData(); // Récupération du champ email
            $user = $userRepository->findOneBy(['email' => $email]); // Recherche de l'utilisateur

            if ($user) {
                // Génération du token unique
                $token = Uuid::v4()->toRfc4122();
                $user->setResetToken($token);
                $user->setResetTokenExpiresAt((new \DateTime())->modify('+1 hour'));

                // Sauvegarde dans la base de données
                $entityManager->flush();

                // Génération du lien de réinitialisation
                $resetLink = $this->generateUrl(
                    'app_reset_password',
                    ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                // Création et envoi de l'email
                $emailMessage = (new Email())
                    ->from('noreply@yourdomain.com')
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de votre mot de passe')
                    ->text("Voici votre lien de réinitialisation : $resetLink");

                $mailer->send($emailMessage);

                // Message de succès
                $this->addFlash('success', 'Un email de réinitialisation a été envoyé.');
                return $this->redirectToRoute('app_login');
            }

            // Si aucun utilisateur n'est trouvé
            $this->addFlash('error', 'Aucun utilisateur trouvé pour cet email.');
        }

        // Affichage du formulaire
        return $this->render('forgot_password/forgotpassword.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }
}
