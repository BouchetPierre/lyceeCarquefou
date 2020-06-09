<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('phone', TextType::class, $this->getConf("Téléphone","Entrez votre numéro", false))
            ->add('address', TextType::class, $this->getConf("Adresse","Entrez votre adresse",false))
            ->add('city', TextType::class, $this->getConf("Ville","Entrez le nom de votre ville de résidence", false))
            ->add('imageFile', FileType::class, $this->getConf('Votre photo (2Mo maxi.)', 'Selectionnez un fichier', false))
            ->add('country',TextType::class, $this->getConf("Pays","Entrez le nom de votre pays de résidence", false))
            ->add('linkIn', TextType::class, $this->getConf("Lien LinkedIn","Copiez l'URL de votre compte LinkedIn", false))
            ->add('emailOk', CheckboxType::class, $this->getConf("J'autorise l'affichage de mon email et de mon téléphone",false, false))
            ->add('typeScoolOne', ChoiceType::class, [
                'choices' => [
                    'BTS ou BTSA' => 'BTS_BTSA',
                        "DUT" => "DUT",
                        "DEUST" => "DEUST",
                        "Licences" => "Licences",
                        "Licences professionnelles" => "Licences_professionnelles",
                        "CPES" => "CPES",
                        "Classes préparatoires (CPGE)" => "Classes_preparatoires",
                        "Cycles préparatoires (écoles d'ingénieurs)" => "Cycles_preparatoires",
                        "Écoles d'ingénieurs" => "Ecoles_ingenieurs",
                        "Études médicales" => "Etudes_medicales",
                        "Écoles du paramédical" => "Ecoles_paramedical",
                        "Écoles du social" => "Ecoles_social",
                        "IEP" => "IEP",
                        "ENS" => "ENS",
                        "Ecoles de commerce" => "Ecoles_commerce",
                        "Ecoles spécialisées" => "Ecoles_specialisees",
                        "Ecoles vétérinaires (ENV)" =>  "Ecoles_veterinaires)",
                        "Ecoles d'art" => "Ecoles_art",
                        "Ecoles de journalisme" => "Ecoles_journalisme",
                        "Formation des enseignants" => "Formation_enseignants",
                        "Filière expertise comptable" => "Filiere_comptable",
                        "Ecoles de police" => "Ecoles_police",
                        "Ecoles d'audiovisuel" => "Ecoles_audiovisuel",
                        "Écoles de la défense" => "Ecoles_defense",
                        "Écoles de gendarmerie" => "Ecoles_gendarmerie"

                ],  'expanded' => false,
                'multiple' => false,
                'label' =>'Type de formation supérieure',
                'required' => false
                ])
            ->add('specialOne', TextType::class, $this->getConf("Spécialité","Indiquez votre spécialité", false))
            ->add('descriptionOne', TextareaType::class, $this->getConf("Commentaire","Ajoutez un commentaire", false))
            ->add('yearsOne', DateType::class, [
                'widget' => 'choice',
                'data' => new \DateTime(),
                'label' =>"Année d'entrée",
                'required' => false
                ])
            ->add('typeScoolTwo', ChoiceType::class, [
                'choices' => [
                    'BTS ou BTSA' => 'BTS_BTSA',
                    "DUT" => "DUT",
                    "DEUST" => "DEUST",
                    "Licences" => "Licences",
                    "Licences professionnelles" => "Licences_professionnelles",
                    "CPES" => "CPES",
                    "Classes préparatoires (CPGE)" => "Classes_preparatoires",
                    "Cycles préparatoires (écoles d'ingénieurs)" => "Cycles_preparatoires",
                    "Écoles d'ingénieurs" => "Ecoles_ingenieurs",
                    "Études médicales" => "Etudes_medicales",
                    "Écoles du paramédical" => "Ecoles_paramedical",
                    "Écoles du social" => "Ecoles_social",
                    "IEP" => "IEP",
                    "ENS" => "ENS",
                    "Ecoles de commerce" => "Ecoles_commerce",
                    "Ecoles spécialisées" => "Ecoles_specialisees",
                    "Ecoles vétérinaires (ENV)" =>  "Ecoles_veterinaires)",
                    "Ecoles d'art" => "Ecoles_art",
                    "Ecoles de journalisme" => "Ecoles_journalisme",
                    "Formation des enseignants" => "Formation_enseignants",
                    "Filière expertise comptable" => "Filiere_comptable",
                    "Ecoles de police" => "Ecoles_police",
                    "Ecoles d'audiovisuel" => "Ecoles_audiovisuel",
                    "Écoles de la défense" => "Ecoles_defense",
                    "Écoles de gendarmerie" => "Ecoles_gendarmerie"
                ],  'expanded' => false,
                'multiple' => false,
                'label' =>'Type de formation supérieure',
                'required' => false
            ])
            ->add('specialTwo', TextType::class, $this->getConf("Spécialité","Indiquez votre spécialité", false))
            ->add('descriptionTwo', TextareaType::class, $this->getConf("Commentaire","Ajoutez un commentaire", false))
            ->add('yearsTwo', DateType::class, [
                'widget' => 'choice',
                'data' => new \DateTime(),
                'label' =>"Année d'entrée",
                'required' => false
            ])
            ->add('typeScoolThree', ChoiceType::class, [
                'choices' => [
                    'BTS ou BTSA' => 'BTS_BTSA',
                    "DUT" => "DUT",
                    "DEUST" => "DEUST",
                    "Licences" => "Licences",
                    "Licences professionnelles" => "Licences_professionnelles",
                    "CPES" => "CPES",
                    "Classes préparatoires (CPGE)" => "Classes_preparatoires",
                    "Cycles préparatoires (écoles d'ingénieurs)" => "Cycles_preparatoires",
                    "Écoles d'ingénieurs" => "Ecoles_ingenieurs",
                    "Études médicales" => "Etudes_medicales",
                    "Écoles du paramédical" => "Ecoles_paramedical",
                    "Écoles du social" => "Ecoles_social",
                    "IEP" => "IEP",
                    "ENS" => "ENS",
                    "Ecoles de commerce" => "Ecoles_commerce",
                    "Ecoles spécialisées" => "Ecoles_specialisees",
                    "Ecoles vétérinaires (ENV)" =>  "Ecoles_veterinaires)",
                    "Ecoles d'art" => "Ecoles_art",
                    "Ecoles de journalisme" => "Ecoles_journalisme",
                    "Formation des enseignants" => "Formation_enseignants",
                    "Filière expertise comptable" => "Filiere_comptable",
                    "Ecoles de police" => "Ecoles_police",
                    "Ecoles d'audiovisuel" => "Ecoles_audiovisuel",
                    "Écoles de la défense" => "Ecoles_defense",
                    "Écoles de gendarmerie" => "Ecoles_gendarmerie"
                ],  'expanded' => false,
                'multiple' => false,
                'label' =>'Type de formation supérieure',
                'required' => false
            ])
            ->add('specialThree', TextType::class, $this->getConf("Spécialité","Indiquez votre spécialité", false))
            ->add('descriptionThree', TextareaType::class, $this->getConf("Commentaire","Ajoutez un commentaire", false))
            ->add('yearsThree', DateType::class, [
                'widget' => 'choice',
                'data' => new \DateTime(),
                'label' =>"Année d'entrée",
                'required' => false
            ])
            ->add('profActivity',CheckboxType::class, $this->getConf("J'exerce une activité proféssionnelle",false, false))
            ->add('yourActivity',TextType::class, $this->getConf("Votre métier","Indiquez votre métier", false))
            ->add('descriptionActivity',TextareaType::class, $this->getConf("Commentaire","Ajoutez un commentaire", false))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
