<?php

namespace App\Controller;

use App\Entity\Lamp;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\FormCommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailController extends AbstractController
{
    #[Route('/galerie/{id}', name: 'app_detail')]
    public function detail(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Trouver la lampe par ID
        $lamp = $entityManager->getRepository(Lamp::class)->find($id);

        // Si aucune lampe n'est trouvée, lancer une exception
        if (!$lamp) {
            throw $this->createNotFoundException("La lampe avec l'ID $id n'existe pas.");
        }

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // Création d'un nouvel objet Comment pour le formulaire
        $comment = new Comment();
        $form = $this->createForm(FormCommentType::class, $comment);
        $form->handleRequest($request);

        // Gestion du formulaire de commentaire
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setLamp($lamp);
            $comment->setUser($user);
            $comment->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès!');

            // Redirection pour éviter la double soumission du formulaire
            return $this->redirectToRoute('app_detail', ['id' => $lamp->getId()]);
        }

        // Récupérer les commentaires associés à la lampe
        $comments = $entityManager->getRepository(Comment::class)->findBy(
            ['lamp' => $lamp],
            ['created_at' => 'DESC'] // Trier par les plus récents
        );

        // Rendu de la vue avec les détails de la lampe et les commentaires
        return $this->render('detail/detail.html.twig', [
            'lamp' => $lamp,
            'comments' => $comments,
            'commentForm' => $form->createView(),
        ]);
    }
}
