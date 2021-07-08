<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        if ($options['ajout']==true):
        $builder
            ->add('nom', TextType::class, [
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Veuillez saisir le nom de l\'article'
                ]
            ])
            ->add('prix', NumberType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Veuillez saisir le prix de l\'article'
                ]
            ] )
            ->add('photo', FileType::class,[
                'required'=>false,
                'label'=>false,

            ])
            ->add('Valider', SubmitType::class)
        ;
        else:

            $builder
                ->add('nom', TextType::class, [
                    'required'=>false,
                    'label'=>false,
                    'attr'=>[
                        'placeholder'=>'Veuillez saisir le nom de l\'article'
                    ]
                ])
                ->add('prix', NumberType::class,[
                    'required'=>false,
                    'label'=>false,
                    'attr'=>[
                        'placeholder'=>'Veuillez saisir le prix de l\'article'
                    ]
                ] )
                ->add('photoModif', FileType::class,[
                    'required'=>false,
                    'label'=>false,

                ])
                ->add('Valider', SubmitType::class)
            ;

            endif;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'ajout'=>false
        ]);
    }
}
