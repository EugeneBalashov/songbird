<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('username')
	        ->add('email')
	        ->add('firstname')
	        ->add('lastname')
	        ->add('password', RepeatedType::class, [
	        	'type' => PasswordType::class,
		        'invalid_message' => 'The password fields must match.',
		        'required' => $options['passwordRequired'],
		        'first_options' => ['label' => 'Password'],
		        'second_options' => ['label' => 'Repeat Password'],
	        ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
	        'passwordRequired' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user';
    }


}
