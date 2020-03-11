<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAnnonceController extends AbstractController
{
    /**
     * @Route("/admin/annonces", name="admin_annonces_index")
     */
    public function index(AnnonceRepository $repo)
    {

        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $repo->findAll()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * @Route("admin/annones/show/{id}/delete", name="admin_annonces_delete")
     *
     * @return Response
     */

    public function delete(Annonce $annonce, EntityManagerInterface $manager){
        $manager->remove($annonce);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_annonces_index');
    }
}
