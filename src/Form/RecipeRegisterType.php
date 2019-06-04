<?php

namespace App\Form;

use App\Entity\Recette;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de la recette",
                "required" => true,
                "attr" => [
                    'placeholder' => 'Nom recette'],
                "constraints" => [
                    new NotBlank,
                    new length([
                        "min" => 2,
                        "max" => 30,
                        "minMessage" => "Nom trop petit (mini 2 caract-res)",
                        "maxMessage" => "Nom trop long (maxi 16 caractères)",
                    ]),            
                ],
            ])

            ->add('quantityGram', IntegerType::class, [
                "label" => "Quanitté en Gramme",
                "required" => false,
                "attr" => [
                    'placeholder' => 'Quantité en Gramme'],
            ])

            ->add('quantityUnit', IntegerType::class, [
                "label" => "Quantité Unitaire",
                "required" => false,
                "attr" => [
                    'placeholder' => 'Quantité Unitaire'
                ],
            ])
            
            ->add('timePrepa', TextType::class, [
                "label" => "Tps de préparation en Heures:Minutes",
                "attr" => [
                    'placeholder' => 'Tps de préparation'],
                // "constraints" => [
                    // new Regex([
                    //     "patter" => "/[0-9]/u",
                    //     "message" => "Erreur sur le nombre",
                    // ]),
                // ],
            ])

            ->add('timeCook', TextType::class, [
                "label" => "Tps de cuisson en Heures:Minutes",
                "attr" => [
                    'placeholder' => 'Tps de cuisson'],
                // "constraints" => [
                    // new Regex([
                    //     "patter" => "/[0-9]/u",
                    //     "message" => "Erreur sur le nombre",
                    // ]),
                // ],
            ])

            ->add('description', TextareaType::class, [
                "label" => "Préparation de la recette",
                "attr" => [
                    'placeholder' => 'Indiquer ici la démarche à suivre pour faire la recette'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
