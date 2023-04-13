<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Worksite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class WorksiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
            'label' => 'Nom du Chantier',
            'required' => true,
            ])
            ->add('description', TextareaType::class, [
            'label' => 'Description du Chantier',
            'required' => false,
            ])
            ->add('image', FileType::class, [
            'label' => 'Photo du Chantier',
            'mapped' => false,
            'required' => false,
            ])
            // ->add('videoUrl', UrlType::class, [
            // 'label' => 'Vidéo du Chantier '
            // ])

            ->add('category', EntityType::class, [
                'label' => 'Choix des catégories',
                'required' => true,
                // spécifie l'entité qu'on veut pouvoir sélectionner
                'class' => Category::class,
                // spécifie la propriété de la classe Category qu'on veut afficher ici : category.name
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true, // Pour avoir choix multiple au lieu de liste déroulante
            ])

            ->add('Soumettre', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worksite::class,
        ]);
    }
}
