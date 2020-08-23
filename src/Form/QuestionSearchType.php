<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\QuestionSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('levelMin', ChoiceType::class, [
                'choices' => Question::getLevelChoices(),
                'required' => false,
                'label'     => 'Niveau minimum',
                'attr'      => [
                    'placeholder' => 'Niveau minimum'
                ]
            ])
            ->add('keyword', TextType::class, [
                'required' => false,
                'label'    => 'Mot clé',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestionSearch::class,
            'method'    => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix() {
        return '';
     }
}
