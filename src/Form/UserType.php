<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',
                TextType::class,
                [
                    'label' => false,
                    'attr'=> ['placeholder'=> "-- Saisissez votre Prénom --"]])
            ->add('familyName',
                TextType::class,
                [
                    'label' => false,
                    'attr'=> ['placeholder'=> "-- Saisissez votre Nom --"]])
            ->add('email',
                EmailType::class,
                [
                    'label' => false,
                    'attr'=> ['placeholder'=> "-- Saisissez votre Email --"]])
            ->add('password',
                PasswordType::class,
                [
                    'label' => false,
                    'attr'=> ['placeholder'=> "-- Saisissez votre Mot de passe --"]])
            ->add('submit',
                SubmitType::class,
                [
                    'label' => "Je 
                    m'inscris", 'attr'=> ['value'=> "Je m'inscris"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
