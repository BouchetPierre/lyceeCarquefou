<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\MessageType;
use App\Repository\AnnonceRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MessageController extends AbstractController
{
    /**
     * permet de creer un message
     * @Route("/message/new/{slug}", name="message_create")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function create(Annonce $annonce, Request $request, EntityManagerInterface $manager)
    {
        $message = new Message();
        $destinataire = $annonce->getAuthor()->getLastname();

        $form= $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $message->setDestinataire($annonce);
            $message->setAuthor($this->getUser());
            $manager->persist($message);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre message a bien été crée !'
            );

            return $this->redirectToRoute("account_index");

        }

        return $this->render('message/index.html.twig', [
            'form' => $form->createView(),
            'destinataire' => $destinataire
        ]);
    }

    /**
     * @Route("/message/show", name="message_show")
     * @IsGranted("ROLE_USER")
     */
    public function index(MessageRepository $repo)
    {
        $user = $this->getUser()->getId();

        $messages = $repo->findByUser($user);
        $messageRecu = $repo->findByDest($user);

      return $this->render('message/show.html.twig', [
            'messages' => $messages,
            'messageRecu' => $messageRecu

        ]);
    }


    /**
     * Permet de supprimer un message
     * @Route("/message/show/{id}/delete", name="message_delete")
     *
     * @return Response
     */

    public function delete(Message $message, EntityManagerInterface $manager){
        $manager->remove($message);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le message a bien été supprimée !'
        );

        return $this->redirectToRoute('message_show');
    }
}
