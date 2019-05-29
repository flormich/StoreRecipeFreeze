<?php

namespace App\Form;

use App\Entity\Page;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class PageRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder   
            ->add('number', IntegerType::class, [
                "label" => "Numéro de page",
                "required" => true,
                "attr" => [
                    'placeholder' => 'Numéro de page'],
                "constraints" => [
                    new Regex([
                        "pattern" => "/[0-9]/u",
                        "message" => "Erreur sur la page"
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}