<?php

namespace modeles;

/**
 * Class Todo
 * @package modeles
 */
class Todo
{
    /**
     * @var int
     */
    private int $id = 0;
    /**
     * @var string
     */
    private string $description = '';
    /**
     * @var bool
     */
    private bool $isDone = false;
    /**
     * @var int
     */
    private int $idList;

    /**
     * Todo constructor.
     * @param int $id
     * @param string $description
     * @param bool $isDone
     * @param int $idList
     */
    public function __construct(int $id, string $description, bool $isDone, int $idList)
    {
        $this->id = $id;
        $this->description = $description;
        $this->isDone = $isDone;
        $this->idList = $idList;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id):void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function getIsDone():bool
    {
        return $this->isDone;
    }

    /**
     * @param bool $value
     */
    public function setIsDone(bool $value):void
    {
        $this->isDone = $value;
    }

    /**
     * @return int
     */
    public function getIdList(): int
    {
        return $this->idList;
    }
}
