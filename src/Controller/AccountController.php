<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\PictureUser;
use App\Form\PasswordUpdateType;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use App\Form\AccountTeachType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AccountController extends AbstractController
{
    /**
     * Formulaire de connexion
     * @Route("/login", name="account_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError'=> $error !== null,
            'username'=> $username
        ]);
    }

    /**
     * permet de se deconnecter
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */

     public function logout(){

     }

     /**
      * permet d'afficher le formulaire d'inscription
      * @Route("/register", name="account_register")
      *
      * @return Response
      */

       public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
            $user = new User();

            $form = $this->createForm(RegistrationType::class, $user);


           $form->handleRequest($request);

           if($form->isSubmitted() && $form->isValid()){
               $hash = $encoder->encodePassword($user, $user->getHash());
               $user->setHash($hash);
               $user->setInscriVal(0);
               $manager->persist($user);
               $manager->flush();

               $this->addFlash(
                    'success',
                    'Votre compte a bien été crée ! Vous pourrez vous connecter après validation de votre compte par le Lycée!'
                );

                return $this->redirectToRoute('account_login');
           }

            return $this->render('account/registration.html.twig', [
               'form' => $form->createView()
            ]);

       }

       /**
        * Permet de modifier le profil user
        *
        * @Route("/account/profile", name="account_profile")
        * @IsGranted("ROLE_USER")
        * @return Response
        */

        public function profil(Request $request, EntityManagerInterface $manager){
            $user= $this->getUser();
            if ($user->getStudOrTeach()=='Student'){
                $form = $this->createForm(AccountType::class, $user);

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    $manager->persist($user);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        'Les données ont bien été modifiées !'
                    );
                }

                return $this->render('account/profile.html.twig', [
                    'form' => $form->createView()
                ]);
            } else {
                $form = $this->createForm(AccountTeachType::class, $user);

                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()) {
                    $manager->persist($user);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        'Les données ont bien été modifiées !'
                    );
                }

                return $this->render('account/profileTeach.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }

    /**
     * Permet de modifier le mot de passe
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager){

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                $form->get('oldPassword')->addError(new FormError('Il y a une erreur concernant votre mot de passe actuel !'));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash= $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien étét modifié !"
                );
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' =>$form->createView()
        ]);
    }


    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     *
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * @return Response
     */

    public function myAccount(){
        return $this->render('user/index.html.twig', [
            'user'=> $this->getUser()

        ]);
    }


}


