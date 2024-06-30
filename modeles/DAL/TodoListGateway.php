<?php

namespace DAL;

use Exception;
use PDO;
use PDOException;

/**
 * Class TodoListGateway
 * @package DAL
 */
class TodoListGateway
{
    /**
     * @var Connexion
     */
    private Connexion $co;

    /**
     * TodoListGateway constructor.
     * @param Connexion $co
     */
    function __construct(Connexion $co)
    {
        $this->co = $co;
    }

    /**
     * Finds a list of id $id
     * @param int $id
     * @return array
     * @throws Exception
     */
    function findListById(int $id): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todolist WHERE id= :id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("Find Error");
        }
    }

    /**
     * Finds all public lists
     * @param int $limit
     * @param int $offset
     * @return array
     * @throws Exception
     */
    function FindAllPublicLists(int $limit, int $offset): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todolist WHERE todolist.isPublic = true LIMIT :limit OFFSET :offset;';
            $param = [':limit' => [$limit, PDO::PARAM_INT], ':offset' => [$offset, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllPublicLists Error");
        }
    }

    /**
     * Finds all the lists belonging to the given user
     * @param int $limit
     * @param int $offset
     * @param int $idUser
     * @return array The array containing the result of the query (all lists)
     * @throws Exception
     */
    function FindAllUserLists(int $limit, int $offset, int $idUser): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todolist WHERE todolist.idUser = :idUser LIMIT :limit OFFSET :offset;';
            $param = [
                ':limit' => [$limit, PDO::PARAM_INT],
                ':offset' => [$offset, PDO::PARAM_INT],
                ':idUser' => [$idUser, PDO::PARAM_INT]
            ];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllUserLists Error");
        }
    }

    /**
     * Inserts a new list in the database with the given attributes
     * @param string $title
     * @param int $idUser
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function insertList(string $title, int $idUser): bool
    {
        ($idUser != 0) ? $isPublic = false : $isPublic = true;
        if ($isPublic) {
            $idUser = "NULL";
        }
        try {
            $query = 'INSERT INTO phptodolist.todolist VALUES(NULL,:title, :isPublic, :idUser/*,1*/);';
            $param = [
                ':title' => [$title, PDO::PARAM_STR],
                ':isPublic' => [$isPublic, PDO::PARAM_BOOL],
                ':idUser' => [$idUser, PDO::PARAM_INT]
            ];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("Insertlist Error");
        }
    }

    /**
     * Updates the title of the given todolist
     * @param int $idList
     * @param string $newTitle
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function updateTitle(int $idList, string $newTitle): bool
    {
        try {
            $query = 'UPDATE phptodolist.todolist SET title = :newTitle WHERE id = :idList;';
            $param = [':newTitle' => [$newTitle, PDO::PARAM_STR],
                ':idList' => [$idList, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("updatetitle error");
        }
    }

    /**
     * Deletes the list od if $idList
     * @param int $idList
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function deleteList(int $idList): bool
    {
        try {
            $query = 'DELETE FROM phptodolist.todolist WHERE id = :idList;';
            $param = [':idList' => [$idList, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("Delete Error");
        }
    }

    /**
     * Finds the number of public lists
     * @return array The number of public lists
     * @throws Exception
     */
    function countNbPublicLists(): array
    {
        try {
            $query = 'SELECT COUNT(*) FROM phptodolist.todolist WHERE todolist.isPublic = true;';
            $param = [];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("countNbPublicLists Error");
        }
    }

    /**
     * Finds the number of lists belonging to the given user
     * @param int $idUser
     * @return array The number of lists
     * @throws Exception
     */
    function countNbUserLists(int $idUser): array
    {
        try {
            $query = 'SELECT COUNT(*) FROM phptodolist.todolist WHERE todolist.idUser = :idUser;';
            $param = [':idUser' => [$idUser, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("countNbUserLists Error");
        }
    }
}