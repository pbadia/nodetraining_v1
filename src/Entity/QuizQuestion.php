<?php

namespace App\Entity;

use App\Repository\QuizQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizQuestionRepository::class)
 */
class QuizQuestion
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=quiz::class, inversedBy="quizQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=question::class, inversedBy="quizquestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=answer::class, inversedBy="quizquestions")
     */
    private $answer;

    public function getQuiz(): ?quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuestion(): ?question
    {
        return $this->question;
    }

    public function setQuestion(?question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?answer
    {
        return $this->answer;
    }

    public function setAnswer(?answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
