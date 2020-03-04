<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    private function getConf($label, $placeholder){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder

            ]
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConf("Nom", "Votre nom ..."))
            ->add('lastname',TextType::class, $this->getConf("Prénom", "Votre prénom ..."))
            ->add('email', EmailType::class, $this->getConf("Email", "Votre adresses email"))
            ->add('picture', UrlType::class, $this->getConf("Photo de profil", "Url de votre avatar ..."))
            ->add('address', TextType::class, $this->getConf("Adresse", "Votre adresse ..."))
            ->add('hash', PasswordType::class, $this->getConf("Mot de Passe", "Choisissez un mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConf("Confirmation de mot de passe","Veuillez confirmer votre mot de passe." ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
