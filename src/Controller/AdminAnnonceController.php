<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
