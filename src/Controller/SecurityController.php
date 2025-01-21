<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    // Action pour afficher le formulaire de connexion
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupération des erreurs de connexion si présentes
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    // Action pour l'inscription de l'utilisateur
    #[Route(path: '/inscription', name: 'app_inscription')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        // Création d'un nouvel utilisateur
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hashage du mot de passe
            $plainPassword = $form->get('Password')->getData(); // Assurez-vous que le nom du champ est 'Password'
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Attribution du rôle utilisateur par défaut
            $user->setRoles(['ROLE_USER']);

            // Sauvegarde dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection vers la page de connexion après l'inscription
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // Action pour la déconnexion (gérée par Symfony)
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
