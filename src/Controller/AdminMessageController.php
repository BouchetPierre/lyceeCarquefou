<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Message;
use App\Entity\Repond;
use App\Repository\MessageRepository;
use App\Repository\RepondRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMessageController extends AbstractController
{
    /**
     * @Route("/admin/message", name="admin_message_index")
     */
    public function index(MessageRepository $repoMess, RepondRepository $repoRep)
    {
        $messages = $repoMess->findAll();
        $reponses = $repoRep->findAll();


        return $this->render('admin/message/index.html.twig', [
            'messages' => $messages,
            'reponses' => $reponses
        ]);
    }

    /**
     * Permet de supprimer un message
     * @Route("admin/message/show/{id}/delete", name="admin_message_delete")
     *
     * @return Response
     */

    public function deleteMes(Message $message, EntityManagerInterface $manager){
        $manager->remove($message);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le message a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_message_index');
    }

    /**
     * Permet de supprimer une reponse
     * @Route("admin/reponse/show/{id}/delete", name="admin_reponse_delete")
     *
     * @return Response
     */

    public function deleteRep(Repond $reponse, EntityManagerInterface $manager){
        $manager->remove($reponse);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le message a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_message_index');
    }
}
