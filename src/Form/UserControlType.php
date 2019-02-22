<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 05/02/19
 * Time: 17:23
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, array(
                'required'=>true,
                'choices'=>array(
                    'Usuario'=>'ROLE_USER',
                    'Administrador'=>'ROLE_ADMIN',
                ),
                'expanded'=>true,
                'multiple'=>true,
                /*'choice_attr'=>function() {
                    return array(
                        'class'=>'form-control',
                    );
                }*/
            ))

            ->add('isactive', CheckboxType::class, array(
                'required'=>false,
                /*'attr'=>array(
                    'class'=>'form-control'
                )*/

            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(['data_class'=>'App\Entity\User']);
    }
}