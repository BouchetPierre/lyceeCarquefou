<?php

namespace App\Controller;

use App\Repository\AdminPublicationRepository;
use App\Repository\AnnonceRepository;
use App\Repository\MessageRepository;
use App\Repository\RepondRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Class HomeController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
    public function home(MessageRepository $repoMes, AdminPublicationRepository $publi, RepondRepository $repoRep){

        if ($this->getUser()){
            $user = $this->getUser()->getId();
            $mesRecu = $repoMes->findByDest($user);
            $repoRecu = $repoRep->findByUserRecu($user);
            $info = count($mesRecu)+count($repoRecu);
            $publications= $publi->findLast();
            return $this->render(
                'home.html.twig', [
                'publications' => $publications,
                'info' => $info
            ]);
        }

        $publications= $publi->findLast();
        return $this->render(
            'home.html.twig', [
            'publications' => $publications
            ]);
    }

    /**
     * Permet d'afficher le logo "message reçu"
     * @param MessageRepository $repoMes
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function messRecu(MessageRepository $repoMes,RepondRepository $repoRep){
        $user = $this->getUser()->getId();
        $mesRecu = $repoMes->findByDest($user);
        $repoRecu = $repoRep->findByUserRecu($user);
        $info = count($mesRecu)+count($repoRecu);

        return $this->render(
            'message/alarmMess.html.twig', [
            'info' => $info
        ]);
    }


}