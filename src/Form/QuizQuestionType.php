<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\QuizQuestion;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
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

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $quizQuestion = $builder->getData();

        $builder
            ->add('answers', EntityType::class, [
                'class' => Answer::class,
                'choices' => $this->fillAnswers($quizQuestion),
                'expanded' => true,
                'multiple' => true,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuizQuestion::class,
        ]);
    }

    private function fillAnswers(QuizQuestion $quizQuestion)
    {
        return $this->answerRepository->findByQuestion($quizQuestion->getQuestion()->getId());
    }
}
