<?php

namespace App\Form;

use App\Entity\Image;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'image",
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
            ])
            ->add('url', FileType::class, [
                'label' => "Image à importer",
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label file-label',
                ],
                'data_class' => null
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de l'image",
                'attr' => [
                    'class' => 'textarea'
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
