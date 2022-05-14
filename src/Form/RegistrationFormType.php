<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType::class,['attr' => ['class' => 'form-control'], 'label' => 'Email'])
        ->add('password', PasswordType::class, [
            'mapped' => true,
            'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'], 
            'constraints' => [
                new NotBlank([
                    'message' => 'Entrer un mot de passe', 
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit être au moins a {{ limit }} caractère',
                    // max length allowed by Symfony for security reasons
                    'max' => 496,
                ]),
            ], 'label' => 'Mot de passe',
                'empty_data' => 'password',
                'required' =>true,
        ]) 
        ->add('lastname',TextType::class,['attr' => ['class' => 'form-control'], 'label' => 'Nom'])
        ->add('firstname',TextType::class,['attr' => ['class' => 'form-control'], 'label' => 'Prenom'])
        ->add('fonction',TextType::class,['attr' => ['class' => 'form-control'], 'label' => 'Fonction'])
        ->add('car',EntityType::class,[
            'class'=> Car::class,
            'choice_label' => 'register',
            'label' => 'Véhicule',
        ])
        ->add('phone',TextType::class,['attr' => ['class' => 'form-control'], 'label' => 'Téléphone'])
            
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices'  => [
                  'Salariées' => 'ROLE_USER',
                  'Administrateur' => 'ROLE_ADMIN',
                ],'attr' => ['class' => 'form-control'], 'label' => 'Status'
            ]);
            // roles field data transformer 
     $builder->get('roles')
         ->addModelTransformer(new CallbackTransformer(
         function ($rolesArray) {
              // transform the array to a string
              return count($rolesArray)? $rolesArray[0]: null;
         },
         function ($rolesString) {
              // transform the string back to an array
              return [$rolesString];
         }
     ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
