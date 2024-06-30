<?php


namespace modeles;


use DateTime;

class LogUser
{
    /**
     * @var int
     */
    private int $idLog;
    /**
     * @var DateTime
     */
    private DateTime $date;
    /**
     * @var string
     */
    private string $action;
    /**
     * @var User
     */
    private User $user;

    /**
     * LogUser constructor.
     * @param int $idLog
     * @param DateTime $date
     * @param string $action
     * @param User $user
     */
    public function __construct(int $idLog, DateTime $date, string $action, User $user)
    {
        $this->idLog = $idLog;
        $this->date = $date;
        $this->action = $action;
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getIdLog(): int
    {
        return $this->idLog;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}