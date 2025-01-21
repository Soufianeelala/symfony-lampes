<?php

namespace App\Controller\Admin;

use App\Entity\Lamp;
use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
                //return parent::index();

       return $this->render('admin/index.html.twig');


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Lampes');
    }

    public function configureMenuItems(): iterable
    {
         yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

      // Section principale
      yield MenuItem::section('Gestion');

      // Lien vers "Mes Lampes"
      yield MenuItem::linkToCrud('Mes Lampes', 'fas fa-lightbulb', Lamp::class);

      // Lien vers "Commentaire"
      yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comment::class);

      // Lien vers "Utilisateurs"
      yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
