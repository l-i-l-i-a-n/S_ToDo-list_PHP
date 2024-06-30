<?php

namespace modeles;

use config\ReturnENUM;
use DAL\Connexion;
use DAL\LogGateway;
use Exception;

/**
 * Class LogModel
 * @package modeles
 */
class LogModel
{
    /**
     * Finds all todolist related logs
     * @return array
     */
    function FindAllTodolistLogs(): array
    {
        try {
            $logGateway = new LogGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $todolistLogs = $logGateway->FindAllTodolistLogs();
            $factory = new LogFactory();
            return $factory->createTodolistLogs($todolistLogs, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }

    /**
     * Finds all todo related logs
     * @return array
     */
    function FindAllTodoLogs(): array
    {
        try {
            $logGateway = new LogGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $todoLogs = $logGateway->FindAllTodoLogs();
            $factory = new LogFactory();
            return $factory->createTodoLogs($todoLogs, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }

    /**
     * Finds all user related logs
     * @return array
     */
    function FindAllUserLogs(): array
    {
        try {
            $logGateway = new LogGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $userLogs = $logGateway->FindAllUserLogs();
            $factory = new LogFactory();
            return $factory->createUserLogs($userLogs, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }
}