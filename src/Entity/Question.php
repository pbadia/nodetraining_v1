<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository", repositoryClass=QuestionRepository::class)
 * @Vich\Uploadable
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $explanation;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $is_available;

    /**
     * @Vich\UploadableField(mapping="question_image", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", cascade={"persist"})
     */
    private $answers;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="questions")
     */
    private $themes;

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
        $this->is_available = false;
        $this->is_multiple = false;
        $this->answers = new ArrayCollection();
        $this->quizQuestions = new ArrayCollection();
        $this->themes = new ArrayCollection();
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

    public function getIsAvailable() : bool
    {
        return $this->is_available;
    }

    public function setIsAvailable(bool $is_available)
    {
        $this->is_available = $is_available;
    }

    /**
     * @param File|null $imageFile
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    /**
     * @return Collection
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function getThemesToString(): string
    {
        $result = "";
        foreach ($this->getThemes() as $i => $item)
        {
            $result = $result .  $item->getName();
            if ($i+1 < $this->getThemes()->count()){
                $result = $result . " - ";
            }
        }
        return $result;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
        }

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

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


}
