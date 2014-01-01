<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class SelectCityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', 'autocomplete_entity', array(
                'class'        => 'SMTC\MainBundle\Entity\City',
                'update_route' => 'examples_autocomplete_get_cities',
                'label'        => 'Ciudad',
                'constraints'  => new NotNull(),
            ))
        ;
    }

    public function getName()
    {
        return 'select_city';
    }
}
