<?php

namespace modeles;

/**
 * Class TodoList
 * @package modeles
 */
class TodoList
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var bool
     */
    private bool $isPublic;
    /**
     * @var int
     */
    private int $idUser;
    /**
     * @var array
     */
    private array $todos;

    /**
     * TodoList constructor.
     * @param int $id
     * @param string $title
     * @param bool $isPublic
     * @param int $idUser
     */
    public function __construct(int $id, string $title, bool $isPublic, int $idUser)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isPublic = $isPublic;
        $this->idUser = $idUser;
        $this->todos = array();
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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return array
     */
    public function getTodos(): array
    {
        return $this->todos;
    }

    /**
     * @param array $todos
     */
    public function setTodos(array $todos): void
    {
        $this->todos = $todos;
    }
}
