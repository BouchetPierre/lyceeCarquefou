<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDachboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dachboard")
     */
    public function index(EntityManagerInterface $manager)
    {
        $users= $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $annonces= $manager->createQuery('SELECT COUNT(a) FROM App\Entity\Annonce a')->getSingleScalarResult();
        $message= $manager->createQuery('SELECT COUNT(m) FROM App\Entity\Message m')->getSingleScalarResult();
        $reponse= $manager->createQuery('SELECT COUNT(r) FROM App\Entity\Repond r')->getSingleScalarResult();
        $publication= $manager->createQuery('SELECT COUNT(r) FROM App\Entity\AdminPlublication r')->getSingleScalarResult();

        return $this->render('admin/dachboard/index.html.twig', [
            'users' => $users,
            'annonces' => $annonces,
            'message' => $message,
            'reponse' => $reponse,
            'publication' => $publication
        ]);
    }
}
