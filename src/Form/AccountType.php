<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{

    private function getConf($label){
        return [
            'label' => $label
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConf('Nom'))
            ->add('lastname', TextType::class, $this->getConf('Prénom'))
            ->add('email', EmailType::class, $this->getConf('Adresse Mail'))
            ->add('yearsBac', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy',
                'html5' => false,
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
                    'Histoire Géo, Sciences politiques' => 'HGSP',
                    'Humanité, littérature et philosophie' => 'HLP',
                    'LLCE' => 'LLCE',
                    'STMG' => 'STMG',
                    'ST2S' => 'ST2S'
                ],  'expanded' => true,
                'multiple' => true,
                'label' =>'Choisissez les options de votre Bac (2 max.)',
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
