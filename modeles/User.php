<?php

namespace modeles;

/**
 * Class User
 * @package modeles
 */
class User
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $pseudo;
    /**
     * @var string
     */
    private string $password;
    /**
     * @var bool
     */
    private bool $isAdmin;

    /**
     * User constructor.
     * @param int $id
     * @param string $pseudo
     * @param string $password
     * @param bool $isAdmin
     */
    public function __construct(int $id, string $pseudo, string $password, bool $isAdmin)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
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
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }


}