<?php

namespace App\Form;

use App\Entity\Category;
use App\DTO\SearchWorksiteCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchWorksiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du chantier : ',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label'=> 'Catégorie : ',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('orderBy', ChoiceType::class, [
                'choices' => [
                    'Identifiant' => 'id',
                    'Titre' => 'title',
                ],
                'required' => true,
                'label' => 'Trier par : ',
            ])
            ->add('direction', ChoiceType::class, [
                'choices'  => [
                    'Croissant' => 'ASC',
                    'Décroissant' => 'DESC',
                 ],
                 'required' => true,
                 'label' => 'Sens du tri : ',
            ])
            ->add('limit', NumberType::class, [
                'required' => true,
                'label' => 'Nombre de résultats : ',
            ])
            ->add('page', NumberType::class, [
                'required' => true,
                'label' => 'Page : ',
            ])

            ->add('send', SubmitType::class, [
                'label' => "Envoyer",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchWorksiteCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
