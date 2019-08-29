<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'=> array('placeholder'=>'Email', 'class' => 'my-1'),
                'label' => 'Email'
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('attr'=>array('placeholder' => 'Password', 'class' => 'my-1'),'label'=> 'Password'),
                'second_options' => array('attr'=>array('placeholder' => 'Re-enter Password', 'class' => 'my-1'),'label'=> 'Re-enter Password'),
            ))
            ->add('Get Started', SubmitType::class, [
                'attr' => array('class' => 'btn btn-primary btn-block')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
