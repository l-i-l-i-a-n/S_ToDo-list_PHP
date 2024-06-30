<?php


namespace modeles;


use DateTime;
use Exception;

/**
 * Class LogFactory
 * @package modeles
 */
class LogFactory
{
    /**
     * @param array $data
     * @param string $type
     * @return array
     * @throws Exception
     */
    public function createTodolistLogs(array $data, string $type) : array
    {
        if ($type == 'mysql')
        {
            $tab = array();
            foreach ($data as $row) {
                try {
                    $tab[] = new LogTodolist($row['idLog'], new DateTime($row['date']), $row['action'], new TodoList($row['idList'], $row['title'], $row['isPublic'], $row['idUser']));
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
            return $tab;
        }
        else
            return array();
    }

    /**
     * @param array $data
     * @param string $type
     * @return array
     * @throws Exception
     */
    public function createTodoLogs(array $data, string $type) : array
    {
        if ($type == 'mysql')
        {
            $tab = array();
            foreach ($data as $row) {
                try {
                    $tab[] = new LogTodo($row['idLog'], new DateTime($row['date']), $row['action'], new Todo($row['idTodo'], $row['description'], $row['isDone'], $row['idList']));
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
            return $tab;
        }
        else
            return array();
    }

    /**
     * @param array $data
     * @param string $type
     * @return array
     * @throws Exception
     */
    public function createUserLogs(array $data, string $type) : array
    {
        if ($type == 'mysql')
        {
            $tab = array();
            foreach ($data as $row) {
                try {
                    $tab[] = new LogUser($row['idLog'], new DateTime($row['date']), $row['action'], new User($row['idUser'], $row['pseudo'], "unknown", $row['isAdmin']));
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
            return $tab;
        }
        else
            return array();
    }
}