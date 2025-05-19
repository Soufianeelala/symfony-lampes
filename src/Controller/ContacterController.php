<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;

final class ContacterController extends AbstractController
{
    #[Route('/contacter', name: 'app_contacter')]
    public function index(Request $request , MailerInterface $mailer): Response
    {
        // Créer une instance du formulaire
        $contactForm = $this->createForm(ContactFormType::class);

        // Gérer la requête (nécessaire pour détecter si le formulaire a été soumis)
        $contactForm->handleRequest($request);

        // Vous pouvez ajouter une logique pour traiter les données soumises ici
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
             // Récupérer les données du formulaire
             $data = $contactForm->getData();
            // Traitez les données ici, comme envoyer un email ou sauvegarder en base
             // Créer l'email
         $email = (new Email())
            ->from('soufianeelalami1991@gmail.com') 
            ->to('souf07091991@gmail.com') 
            ->subject('Nouveau message de contact') 
            ->text(
                "Nom:{$data['name']}\n".
                "Email:{$data['email']}\n".
                "Message:{$data['message']}\n"

            );
            $mailer->send($email);
        }

        // Rendre la vue en passant le formulaire
        return $this->render('contacter/contacter.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
