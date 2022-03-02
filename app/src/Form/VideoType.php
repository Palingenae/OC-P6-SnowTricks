<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de la vidéo",
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
            ])
            ->add('url', TextType::class, [
                'label' => "Lien de la vidéo",
                'attr' => [
                    'class' => 'input'
                ],
                'label_attr' => [
                    'class' => 'form__label',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de la vidéo",
                'attr' => [
                    'class' => 'input'
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
            'data_class' => Video::class,
        ]);
    }
}
