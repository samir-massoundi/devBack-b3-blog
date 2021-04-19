<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('headline', TextType::class)
            ->add('subheadline', TextType::class)
            ->add('articleContent', TextAreaType::class)
            // ->add('createdAt')
            ->add('imageArticle')
            ->add('categorie', EntityType::class,
            [
                'class' => Categorie::class,
                'choice_label'=> function($category){
                    return $category->getName();
                },
                'expanded' => false,
                'multiple' => false
            ])
            ->add('isVisible', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
