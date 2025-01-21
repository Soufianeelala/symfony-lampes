<?php

namespace App\Controller;

use App\Entity\Lamp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DeleteLampeController extends AbstractController
{
    #[Route('/delete/lampe/{id}', name: 'app_delete_lampe')]
    public function index(Lamp $lampe, Request $request, EntityManagerInterface $entityLampe): Response
    {
        if ($this->isCsrfTokenValid('Supprimer' . $lampe->getId(), $request->get('_token'))) {
            $entityLampe->remove($lampe);
            $entityLampe->flush();
            $this->addFlash('success', 'La suppression a été effectuée');
        }

        return $this->redirectToRoute('app_Home');
    }
}
