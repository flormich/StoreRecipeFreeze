<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class StockRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantityUnit', IntegerType::class, [
                "label" => "Quantités Unitaires",
                "attr" => [
                    'placeholder' => 'Quantités Unitaires'],
                "constraints" => [
                    new Regex([
                        "pattern" => "/[0-9]/u",
                        "message" => "error.quantityUnit",
                    ]),
                ],
            ])

            ->add('quantityGram', IntegerType::class, [
                "label" => "Quantités en Grammes",
                "attr" => [
                    'placeholder' => 'Quantités en Grammes'],
                "constraints" => [
                    new Regex([
                        "pattern" => "/[0-9]/u",
                        "message" => "error.quantityGr",
                    ]),
                ],
            ])

            ->add('dlc', TextType::class, [
                "label" => "Date Limite de Consommation",
                "attr" => [
                    'placeholder' => 'Date limite de Consommation'],
                "constraints" => [
                    new NotBlank,
                    new length([
                        "min" => 2,
                        "max" => 30,
                        "minMessage" => "error.min.name",
                        "maxMessage" => "error.max.name",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}