<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository", repositoryClass=QuestionRepository::class)
 */
class Question
{

    const DIFFICULTY_LEVEL = [
        0 => 'Débutant',
        1 => 'Intermédiaire',
        2 => 'Avancé'
    ];

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
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="questions")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity=QuizQuestion::class, mappedBy="question")
     */
    private $quizQuestions;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $level;

    public function __construct()
    {
        // Initializing variables
        $this->level = 0;
        $this->answers = new ArrayCollection();
        $this->quizQuestions = new ArrayCollection();
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

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->label);
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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Quizquestion[]
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizQuestions): self
    {
        if (!$this->quizQuestions->contains($quizQuestions)) {
            $this->quizQuestions[] = $quizQuestions;
            $quizQuestions->setQuestion($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizQuestions): self
    {
        if ($this->quizQuestions->contains($quizQuestions)) {
            $this->quizQuestions->removeElement($quizQuestions);
            // set the owning side to null (unless already changed)
            if ($quizQuestions->getQuestion() === $this) {
                $quizQuestions->setQuestion(null);
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

    public function getLevelDifficulty(): string {
        return self::DIFFICULTY_LEVEL[$this->level];
    }

    public static function getLevelChoices()
    {
        return array_flip(self::DIFFICULTY_LEVEL);
    }

}
