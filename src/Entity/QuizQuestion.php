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
    const QUESTION_RESULT = [
        0 => 'Faux',
        1 => 'Partiellement correct',
        2 => 'Correct'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizQuestions")
     */
    private $quiz;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="quizQuestions")
     */
    private $question;

    /**
     * @ORM\ManyToMany(targetEntity=Answer::class, inversedBy="quizQuestions")
     */
    private $answers;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $result;

    public function __construct()
    {
        $this->result = self::QUESTION_RESULT[0];
        $this->answers = new ArrayCollection();
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

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getResult(): ?int
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }
}
