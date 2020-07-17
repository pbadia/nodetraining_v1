<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $explanation;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $is_correct;

    /**
     * @ORM\ManyToOne(targetEntity=question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=Quizquestion::class, mappedBy="answer")
     */
    private $quizquestions;

    public function __construct()
    {
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

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(bool $is_correct): self
    {
        $this->is_correct = $is_correct;

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
            $quizquestion->setAnswer($this);
        }

        return $this;
    }

    public function removeQuizquestion(Quizquestion $quizquestion): self
    {
        if ($this->quizquestions->contains($quizquestion)) {
            $this->quizquestions->removeElement($quizquestion);
            // set the owning side to null (unless already changed)
            if ($quizquestion->getAnswer() === $this) {
                $quizquestion->setAnswer(null);
            }
        }

        return $this;
    }


}
