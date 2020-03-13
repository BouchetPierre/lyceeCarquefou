<?php

namespace App\Controller;

use App\Entity\AdminPlublication;
use App\Form\AdminPlublicationType;
use App\Repository\AdminPlublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminPlublicationController extends AbstractController
{
    /**
     * Permet de faire une publication
     *
     * @Route("/admin/plublication/new", name="admin_publication")
     *
     * @return Response
     */

    public function create(Request $request, EntityManagerInterface $manager){
        $publication = new AdminPlublication();

        $form= $this->createForm(AdminPlublicationType::class, $publication);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $publication->setAuthor($this->getUser());

            $brochureFile = $form->get('brochure')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();


                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $publication->setBrochureFilename($newFilename);
            }

            $manager->persist($publication);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre publication a bien été crée !'
            );

            return $this->redirectToRoute("admin_dachboard");
        }

        return $this->render('admin/plublication/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * Permet de voir les publications
     * @Route("/publications/show", name="plublication_show")
     * @IsGranted("ROLE_USER")
     */
    public function index(AdminPlublicationRepository $repo)
    {

        $publications = $repo->findAll2();

        return $this->render('publications/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/admin/publications", name="admin_publications_index")
     */
    public function indexAdmin(AdminPlublicationRepository $repo)
    {
        $publications = $repo->findAll();

        return $this->render('admin/plublication/index.html.twig', [
            'publications' => $publications
        ]);
    }

    /**
     * Permet de supprimer une publication
     * @Route("admin/publications/{id}/delete", name="admin_publications_delete")
     *
     * @return Response
     */

    public function deleteMes(AdminPlublication $publication, EntityManagerInterface $manager){
        $manager->remove($publication);
        $manager->flush();

        $this->addFlash(
            'success',
            "La publication a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_publications_index');
    }

    /**
     * Permet d'afficher et de modifier une publication
     * @Route("admin/publication/{id}/edit", name="admin_publications_edit")
     *      *
     * @return Response
     */

    public function edit(AdminPlublication $publication, Request $request, EntityManagerInterface $manager){

        $form= $this->createForm(AdminPlublicationType::class, $publication);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($publication);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre publication a bien été modifiée !'
            );

            return $this->redirectToRoute('admin_publications_index');
        }
        return $this->render('admin/plublication/edit.html.twig',[
            'form' => $form->createView(),
            'publication'=> $publication
        ]);
    }
}
