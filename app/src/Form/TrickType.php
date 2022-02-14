<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du trick',
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4,
                        'max' => 255
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4,
                        'max' => 255
                    ])
                ]
            ])
            ->add('coverImage', ImageType::class, [])
            // ->add('images', CollectionType::class, [
            //     'entry_type' => ImageType::class,
            //     'entry_options' => [
            //         'label' => false
            //     ],
            //     'allow_add' => true,
            //     'by_reference' => false
            // ])
            // ->add('video', TextType::class, [
            //     'label' => 'Vidéo du trick',
            //     'attr' => [
            //         'class' => 'input'
            //     ],
            //     'label' => [
            //         'class' => 'form__label'
            //     ],
            //     'constraints' => [
            //         new NotBlank(),
            //         new Length([
            //             'min' => 4,
            //             'max' => 255
            //         ])
            //     ]
            // ])
            // ->add('trickGroup', EntityType::class, [
            //     'class' => TrickGroup::class,
            //     'choice_label' => 'Catégorie du trick'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
