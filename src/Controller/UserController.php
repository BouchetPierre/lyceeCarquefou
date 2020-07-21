<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * permet de voir un User défini
     * @Route("/user/user/{id}", name="user_show")
     * @IsGranted("ROLE_USER")
     *
     */
    public function index(User $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/show/user", name="admin_user_index")
     *
     */
    public function users(UserRepository $repo)
    {
        $users = $repo->findAll();
        return $this->render('admin/user.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Permet de valider un user
     * @Route("/admin/user/{id}/valid", name="admin_user_val")
     *
     * @return Response
     */

    public function valideInscrip(User $user, EntityManagerInterface $manager, \Swift_Mailer $mailer){
        $user->setInscriVal(1);
        $manager->persist($user);
        $manager->flush();
        $mailUser = $user->getEmail();
        $this->notify($mailUser, $mailer);

        $this->addFlash(
            'success',
            "L'utilisateur a bien été validé!"
        );

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Permet de supprimer un user
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     *
     * @return Response
     */

    public function delete(User $user, EntityManagerInterface $manager){
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'utilisateur a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/stud", name="user_allShowStud")
     * @IsGranted("ROLE_USER")
     */
     public function allUStud(UserRepository $repo)
    {
        $users = $repo->findAllStud();
        return $this->render('/user/allUsers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/teach", name="user_allShowTeach")
     * @IsGranted("ROLE_USER")
     */
    public function allUTeach(UserRepository $repo)
    {
        $users = $repo->findAllTeach();
        return $this->render('/user/allUsers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * permet de trouver les users en fonction d'une formation
     * @Route("/form/form/{form}", name="user_show_form")
     * @IsGranted("ROLE_USER")
     */
    public function allUform($form, AnnonceRepository $repo)
    {
        $users = $repo->findAllForForm($form);
        return $this->render('/user/formation.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * permet de trouver les users en fonction d'une formation
     * @Route("/form/cat/{cat}", name="user_show_cat")
     * @IsGranted("ROLE_USER")
     */
    public function allUcat($cat, AnnonceRepository $repo)
    {
        $users = $repo->findAllForCat($cat);
        return $this->render('/user/formation.html.twig', [
            'users' => $users
        ]);
    }




    private function notify($mailUser, \Swift_Mailer $mailer) //function to send a mail to member for notify cancellation
    {

        $message = (new \Swift_Message('Validation de votre compte !!!'))
            ->setFrom('bouchet.hp@gmail.com')
            ->setTo($mailUser)
            ->setBody('Félicitation, votre compte à été validé par le Lycée !!!');

        try {
            $mailer->send($message);
        }
        catch(\Exception $e) {

        }
    }



}
