<?php
namespace App\Controller;

use App\Entity\Lamp;
use App\Entity\Comment;
use App\Entity\Note;
use App\Form\CommentType;
use App\Form\FormCommentType;
use App\Form\FormNoteType; 
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
            ['createdAt' => 'DESC'] // Trier par les plus récents

        );

        // Récupérer les notes associées à la lampe
        $notes = $lamp->getId(); // C'est ici que vous accédez à la relation "notes" de la lampe
//dd($notes);
        // Calculer la moyenne des notes
        $averageNote = null; // Par défaut
       if (count($notes) > 0) {
            $total = 0;
            foreach ($notes as $note) {
                $total += $note->getNoteLamp(); // Utiliser la méthode pour récupérer la note
             }
             $averageNote = $total / count($notes); // Moyenne des notes
         }

        // Créer un objet Note pour le formulaire d'ajout de note
        $note = new Note();
        $noteForm = $this->createForm(FormNoteType::class, $note);
        $noteForm->handleRequest($request);

        if ($noteForm->isSubmitted() && $noteForm->isValid()) {
            $note->setLamp($lamp);
            $note->setUser($user);
            $entityManager->persist($note);
            $entityManager->flush();

            $this->addFlash('success', 'Note ajoutée avec succès!');

            return $this->redirectToRoute('app_detail', ['id' => $lamp->getId()]);
        }

        // Rendu de la vue avec les détails de la lampe, les commentaires, et les notes
        return $this->render('detail/detail.html.twig', [
            'lamp' => $lamp,
            'comments' => $comments,
            'commentForm' => $form->createView(),
            'averageNote' => $averageNote, // Moyenne des notes
            'notes' => $notes, // Liste des notes individuelles
            'noteForm' => $noteForm->createView(), // Formulaire pour ajouter une note
        ]);
    }
}
