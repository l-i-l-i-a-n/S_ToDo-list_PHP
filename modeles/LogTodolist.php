<?php


namespace modeles;


use DateTime;

class LogTodolist
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
     * @var TodoList
     */
    private TodoList $list;

    /**
     * LogTodolist constructor.
     * @param int $idLog
     * @param DateTime $date
     * @param string $action
     * @param TodoList $list
     */
    public function __construct(int $idLog, DateTime $date, string $action, TodoList $list)
    {
        $this->idLog = $idLog;
        $this->date = $date;
        $this->action = $action;
        $this->list = $list;
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
     * @return TodoList
     */
    public function getList(): TodoList
    {
        return $this->list;
    }
}