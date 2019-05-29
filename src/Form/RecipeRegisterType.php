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

            ->add('numberPeople', IntegerType::class, [
                "label" => "Nombre de personne",
                "attr" => [
                    'placeholder' => 'Nombre de personne'],
                "constraints" => [
                    new Regex([
                        "pattern" => "/[0-9]/u",
                        "message" => "Erreur sur le nombre",
                    ]),
                ],
            ])

            ->add('timePrepa', TimeType::class, [
                "label" => "Tps de préparation",
                "attr" => [
                    'placeholder' => 'Tps de préparation'],
                // "constraints" => [
                    // new Regex([
                    //     "patter" => "/[0-9]/u",
                    //     "message" => "Erreur sur le nombre",
                    // ]),
                // ],
            ])

            ->add('timeBaking', TimeType::class, [
                "label" => "Tps de cuisson",
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
                "label" => "Détail",
                "attr" => [
                    'placeholder' => 'Détail'],
            ])

            
            ->add('page', IntegerType::class, [
                "label" => "Numéro de page",
                "attr" => [
                    'placeholder' => 'Numéro de page'],
                "constraints" => [
                    new Regex([
                        "pattern" => "/[0-9]/u",
                        "message" => "Erreur indiquer un nombre",
                    ])
                ],
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
