<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created_at')
            ->add('updated_at')
            ->add('is_running');
           // ->add('user');/*
           /*->add('quizquestions', CollectionType::class, [
               'entry_type' => QuizQuestionType::class,
               'entry_options' => ['label' => false],
               'allow_add' => true,
               'by_reference' => false,
               'allow_delete' => true,
           ]);*/



        /*$builder->add('quizquestions', EntityType::class, [
            'class' => QuizQuestion::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('q');
                    //->where('q.id IN(:question_ids)')
                    //->setParameter('question_ids', '');
            },
            'choice_label' => 'username',
        ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}

