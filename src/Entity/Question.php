<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question")
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity=theme::class, inversedBy="questions")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=Quizquestion::class, mappedBy="question", orphanRemoval=true)
     */
    private $quizquestions;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->quizquestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getTheme(): ?theme
    {
        return $this->theme;
    }

    public function setTheme(?theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Quizquestion[]
     */
    public function getQuizquestions(): Collection
    {
        return $this->quizquestions;
    }

    public function addQuizquestion(Quizquestion $quizquestion): self
    {
        if (!$this->quizquestions->contains($quizquestion)) {
            $this->quizquestions[] = $quizquestion;
            $quizquestion->setQuestion($this);
        }

        return $this;
    }

    public function removeQuizquestion(Quizquestion $quizquestion): self
    {
        if ($this->quizquestions->contains($quizquestion)) {
            $this->quizquestions->removeElement($quizquestion);
            // set the owning side to null (unless already changed)
            if ($quizquestion->getQuestion() === $this) {
                $quizquestion->setQuestion(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

}
