<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
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
    private $score;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $is_running;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quizzes")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @ORM\OneToMany(
     *     targetEntity=QuizQuestion::class,
     *     mappedBy="quiz",
     *     orphanRemoval=true),
     *     cascade={"persist"}
     */
    private $quizQuestions;

    public function __construct()
    {
        $this->score = 0;
        $this->is_running = true;
        $this->created_at = new \DateTime();
        $this->quizQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIsRunning(): ?bool
    {
        return $this->is_running;
    }

    public function setIsRunning(string $state): self
    {
        $this->is_running = $state;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|QuizQuestion[]
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if (!$this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions[] = $quizQuestion;
            $quizQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if ($this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions->removeElement($quizQuestion);
            // set the owning side to null (unless already changed)
            if ($quizQuestion->getQuiz() === $this) {
                $quizQuestion->setQuiz(null);
            }
        }

        return $this;
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

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }

    /**
     * Add some points to the score
     *
     * @param $points
     */
    public function addScore($points): void
    {
        $this->score += $points;
    }

    /**
     * Get all the themes corresponding to the quiz without repetition
     *
     * @return string
     */
    public function getThemes() : string
    {
        $themes = array();

        // For each quizQuestion item, get the corresponding themes if not already listed
        foreach ($this->quizQuestions as $quizQuestion){
            foreach ($quizQuestion->getQuestion()->getThemes() as $theme) {
                $themeName = $theme->getName();
                if (!in_array($themeName, $themes)) {
                    $themes[] = $themeName;
                }
            }
        }

        // Return the themes as a string
        return implode($themes, ", ");

    }
}
