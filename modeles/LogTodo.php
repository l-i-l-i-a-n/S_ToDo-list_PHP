<?php


namespace modeles;


use DateTime;

class LogTodo
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
     * @var Todo
     */
    private Todo $todo;

    /**
     * LogTodo constructor.
     * @param int $idLog
     * @param DateTime $date
     * @param string $action
     * @param Todo $todo
     */
    public function __construct(int $idLog, DateTime $date, string $action, Todo $todo)
    {
        $this->idLog = $idLog;
        $this->date = $date;
        $this->action = $action;
        $this->todo = $todo;
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
     * @return Todo
     */
    public function getTodo(): Todo
    {
        return $this->todo;
    }
}