<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('email', EmailType::class, $this->getConf("Email", "Votre adresse email"))
            ->add('studOrTeach', ChoiceType::class, [
                'choices' => [
                    'Etudiant' => 'Student',
                    'Professeur' => 'Teacher'
                ],  'expanded' => true,
                'multiple' => false,
                'label' =>'Vous êtes:',
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
            ->add('yearsBac', DateType::class, [
                'widget' => 'choice',
                'data' => new \DateTime(),
                'label' =>"Année d'obtention du BAC"
            ])
            ->add('typeBac', ChoiceType::class, [
                'choices' => [
                    'Série générale' => 'Serie_generale',
                    'Série technologique' => 'Serie_technologique'
                ],  'expanded' => true,
                'multiple' => false,
                'label' =>'Choisissez la série de Bac',
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
            ->add('BacSpec2', ChoiceType::class, [
                'choices' => [
                    'SES' => 'SES',
                    'Maths' => 'Maths',
                    'SVT' => 'SVT',
                    'Physique' => 'Physique',
                    'NSI' => 'NSI',
                    'SI' => 'SI',
                    'Histoire Géo, Sciences politiques' => 'Histoire-Geo_Sciennes-Po',
                    'Humanité, littérature et philosophie' => 'Humanite_Litterature_Philo',
                    'LLCE' => 'LLCE',
                    'STMG' => 'STMG',
                    'ST2S' => 'ST2S'
                ],  'expanded' => true,
                'multiple' => true,
                'label' =>'Indiquez les spécialités de votre Bac (2 max.)',
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
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
