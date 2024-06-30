<?php

namespace DAL;

use Exception;
use PDOException;

/**
 * Class LogGateway
 * @package modeles
 */
class LogGateway
{
    /**
     * The Connection class instance
     * @var Connexion
     */
    private Connexion $co;

    /**
     * UserGateway constructor.
     * @param $connexion
     */
    public function __construct(Connexion $connexion)
    {
        $this->co = $connexion;
    }

    /**
     * Finds and return all todolist_logs to be displayed in admin page
     * @return array Contains the logs
     * @throws Exception
     */
    public function FindAllTodolistLogs(): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todolist_log;';
            $params = [];
            $this->co->executeQuery($query, $params);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllTodolistLogs Error");
        }
    }

    /**
     * Finds and return all todo_logs to be displayed in admin page
     * @return array Contains the logs
     * @throws Exception
     */
    public function FindAllTodoLogs(): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todo_log;';
            $params = [];
            $this->co->executeQuery($query, $params);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllTodoLogs Error");
        }
    }

    /**
     * Finds and return all user_logs to be displayed in admin page
     * @return array Contains the logs
     * @throws Exception
     */
    public function FindAllUserLogs(): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.user_log;';
            $params = [];
            $this->co->executeQuery($query, $params);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllUserLogs Error");
        }
    }
}