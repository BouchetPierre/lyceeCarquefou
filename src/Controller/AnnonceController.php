<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnnonceController extends AbstractController
{

    /**
     * Permet de creer une fiche
     *
     * @Route ("/annonces/new", name="annonce_create")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */

    public function create(Request $request, EntityManagerInterface $manager){
        $annonce = new Annonce();

        $form= $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->getUser()->setFicheOK(1);
            $annonce->setAuthor($this->getUser());
            $manager->persist($annonce);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre fiche a bien été crée !'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render("annonce/new.html.twig", [
            'form' => $form->createView()
        ]);

    }

     /**
     * Permet de voir les fiches en fonction du type de formation
     * @Route("/annonces/{type}", name="annonces_index")
     * @IsGranted("ROLE_USER")
     */
    public function index($type, AnnonceRepository $repo)
    {

        $annonces = $repo->findByType($type);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }



    /**
     * Permet d'afficher et de modifier une fiche
     * @Route("annonces/show/{id}/edit", name="fiche_edit")
     * @Security("is_granted('ROLE_USER') and user === annonce.getAuthor()", message="Vous n'est pas propriétaire de cette annonce !")
     *
     * @return Response
     */

    public function edit(Annonce $annonce, Request $request, EntityManagerInterface $manager){

        $form= $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($annonce);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre fiche a bien été modifiée !'
            );

            return $this->redirectToRoute('account_index', [
                'user'=> $this->getUser()
                ]);
        }
        return $this->render('annonce/edit.html.twig',[
            'form' => $form->createView(),
            'annonce'=> $annonce
        ]);
    }


    /**
     * Permet de voir une afiche définie
     *
     * @Route("/annonces/show/{id}", name="annonces_show")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */


    public function show($id, AnnonceRepository $repo){

        $annonce = $repo->findOneById($id);

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }


    /**
     * Permet de supprimer une fiche
     * @Route("/annones/show/{id}/delete", name="fiche_delete")
     * @Security("is_granted('ROLE_USER') and user === annonce.getAuthor()")
     *
     * @return Response
     */

    public function delete(Annonce $annonce, EntityManagerInterface $manager){
        $this->getUser()->setFicheOK(0);
        $manager->remove($annonce);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre annonce a bien été supprimée !'
        );

        return $this->redirectToRoute('account_index');
    }
}
