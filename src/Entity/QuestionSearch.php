<?php


namespace App\Entity;


class QuestionSearch
{
    /**
     * @var int|null
     */
    private $levelMin;

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
}