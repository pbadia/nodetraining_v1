<?php

namespace App\Entity;

use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizQuestionRepository::class)
 */
class QuizQuestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizQuestions")
     */
    private $quiz;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="quizQuestions")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Answer::class, inversedBy="quizQuestions")
     */
    private $answer;


    public function __construct()
    {
        //$this->result = self::QUESTION_RESULT[0];
        //$this->answers = new ArrayCollection();
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

}
