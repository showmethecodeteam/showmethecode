<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', 'password', array(
            'mapped'      => false,
            'label'       => 'Password',
            'constraints' => array(
                new NotBlank(),
                new UserPassword()
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Symfony\Component\Security\Core\User\User'
        ));
    }

    public function getName()
    {
        return 'password';
    }
}
