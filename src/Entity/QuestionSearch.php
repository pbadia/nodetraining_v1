<?php


namespace App\Entity;


class QuestionSearch
{
    /**
     * @var int|null
     */
    private $levelMin;

    private $keyword;

    /**
     * @param int|null $levelMin
     * @return QuestionSearch
     */
    public function setLevelMin(?int $levelMin): QuestionSearch
    {
        $this->levelMin = $levelMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLevelMin(): ?int
    {
        return $this->levelMin;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword(string $keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return mixed
     */
    public function
    getKeyword() : ?string
    {
        return $this->keyword;
    }

}