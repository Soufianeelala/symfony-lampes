<?php
namespace App\Controller;

use App\Entity\Lamp;
use App\Form\FormLampType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

final class LampController extends AbstractController
{
    // Route pour afficher la liste des lampes
    #[Route('/lamp', name: 'app_lamp')]
    public function lamp(Request $request, EntityManagerInterface $entityManager ,Security $security): Response
    {
        
        // 2. Création d'une nouvelle instance de l'entité Lamp pour ajouter une lampe
        $lamp = new Lamp();
        $form = $this->createForm(FormLampType::class, $lamp);
        // Récupération des 4 dernières lampes par la date de création
        $lamps = $entityManager->getRepository(Lamp::class)
        ->findBy([], ['creates_at' => 'DESC'], 4); // Trie par date de création, descendante, limite à 4 résultats



        // 3. Traitement des données soumises via la requête HTTP (POST)
        $form->handleRequest($request);

        // 4. Vérification si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {
            // Définir la date de création à la date actuelle
            $lamp->setCreatesAt(new \DateTimeImmutable());  // A 'creates_at' 
           // 
            $user=$security->getUser();
            $lamp->setUser($user);

            // Persister l'entité lampe
            $entityManager->persist($lamp);
        
            // Sauvegarder en base de données
            $entityManager->flush();
        
            // Message flash pour indiquer le succès
            $this->addFlash('success', 'Lampe ajoutée avec succès');
        
            // Rediriger vers la page d'accueil ou autre route
            return $this->redirectToRoute('app_Home');
        }
        

        // 5. Afficher la vue avec les 4 dernières lampes et le formulaire
        return $this->render('lamp/lamp.html.twig', [
            'lamps' => $lamps,  // Passer les lampes à la vue
            'form' => $form->createView(), // Passer le formulaire à la vue
        ]);
    }
}
