<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\QuizQuestion;
use App\Form\DataTransformer\CollectionToAnswerTransformer;
use App\Repository\AnswerRepository;
use App\Service\QuizService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizQuestionType extends AbstractType
{
    /**
     * @var AnswerRepository
     */
    private $answerRepository;

    /**
     * QuizQuestionType constructor.
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder){
                $quizQuestion = $event->getData();
                $form = $event->getForm();

                $form->add('answer', EntityType::class, [
                    'class' => Answer::class,
                    'choices' => $this->fillAnswers($quizQuestion),
                    'expanded' => true,
                    'multiple' => false,
                    'label' => false,
                ]);

                /*if ($this->answerRepository->getIsMultipleQuestion($quizQuestion->getQuestion()->getId())){
                    $form->add('answers', EntityType::class, [
                        'class' => Answer::class,
                        'choices' => $this->fillAnswers($quizQuestion),
                        'expanded' => true,
                        'multiple' => true,
                    ]);
                } else {
                    $form->add('answers', EntityType::class, [
                        'class' => Answer::class,
                        'choices' => $this->fillAnswers($quizQuestion),
                        'expanded' => true,
                        'multiple' => false,
                        'model_transformer' => new CollectionToArrayTransformer(),
                    ]);
                }*/
            })
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class
        ]);
    }

    private function fillAnswers(QuizQuestion $quizQuestion)
    {
        return $this->answerRepository->findByQuestion($quizQuestion->getQuestion()->getId());
    }
}
