<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * permet d'avoir la config d'un champ
     * @param $label
     * @param $placeholder
     * @return array
     */

    private function getConf($label, $placeholder, $required){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder

            ],
            'required' => $required
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, $this->getConf("titre","Tapez votre titre d'annonce", true))
            ->add('introduction', TextType::class, $this->getConf("Introduction","Donnez une description rapide",true))
            ->add('content', TextareaType::class, $this->getConf("Description détaillée","Donnez une description détaillée de votre annonce", true))
            ->add('imageFile', FileType::class, ['required'=> false])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Annonce'=> 'Annonce',
                    'Prêt Bricolage' => 'Prêt-Bricolage',
                    'Prêt Jardinage' => 'Prêt_Jardinage',
                    'Achat Collectif' => 'Achat_Collectif',
                    'Sortie' => 'Sortie',
                    'Fête' => 'Fête',
                    'Information Le Mas' => 'Information_Le_Mas'
                ],  'expanded' => true,
                'multiple' => false,
                'label_attr'=>[
                    'class'=>'radio-inline'
                ] ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
