<?php

namespace App\Controller;

use App\Repository\AdminPlublicationRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Class HomeController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
    public function home(MessageRepository $repoMes, AdminPlublicationRepository $publi){

        if ($this->getUser()){
            $user = $this->getUser()->getId();
            $mesRecu = $repoMes->findByDest($user);
            $info = count($mesRecu);
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