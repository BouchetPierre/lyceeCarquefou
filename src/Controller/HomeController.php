<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Class HomeController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
    public function home(AnnonceRepository $repo, MessageRepository $repoMes){

        $user = $this->getUser()->getId();
        $mesRecu = $repoMes->findByDest($user);
        $info = count($mesRecu);
        $annonces = $repo->findLastInfo();

        return $this->render(
            'home.html.twig', [
            'annonces' => $annonces,
             'info' => $info
            ]);
    }

    /**
     * Permet d'afficher le logo "message reçu"
     * @param MessageRepository $repoMes
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function messRecu(MessageRepository $repoMes){
        $user = $this->getUser()->getId();
        $mesRecu = $repoMes->findByDest($user);
        $info = count($mesRecu);
        return $this->render(
            'message/alarmMess.html.twig', [
            'info' => $info
        ]);
    }

}