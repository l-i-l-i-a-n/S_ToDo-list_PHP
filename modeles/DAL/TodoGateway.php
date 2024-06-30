<?php

namespace DAL;

use Exception;
use PDO;
use PDOException;

/**
 * Class TodoGateway
 * @package modeles
 */
class TodoGateway
{
    /**
     * @var Connexion
     */
    private Connexion $co;

    /**
     * TodoGateway constructor.
     * @param Connexion $co
     */
    function __construct(Connexion $co)
    {
        $this->co = $co;
    }

    /**
     * Finds all todos in the list of id $idList
     * @param int $idList
     * @return array
     * @throws Exception
     */
    function FindAllTodosByListId(int $idList): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todo WHERE idList=:idlist;';
            $param = [':idlist' => [$idList, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("FindAllTodosByListID Error");
        }
    }

    /**
     * Inserts a todo in the database, with the given $description and $idList
     * @param string $description
     * @param int $idListe
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function insertTodo(string $description, int $idListe): bool
    {
        try {
            $query = 'INSERT INTO phptodolist.todo VALUES(NULL,:description,false, :idListe);';
            $param = [':description' => [$description, PDO::PARAM_STR], ':idListe' => [$idListe, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("Insert Error");
        }
    }

    /**
     * Deletes the todo of id $id
     * @param int $id
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function deleteTodo(int $id): bool
    {
        try {
            $query = 'DELETE FROM phptodolist.todo WHERE id = :id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("Delete Error");
        }
    }

    /**
     * Finds if a todo is public or not
     * @param int $id : L'identifiant de la todo.
     * @return array Array containing the isPublic of the todo corresponding to $id
     * @throws Exception
     */
    function isPublic(int $id): array
    {
        try {
            $query = 'SELECT isPublic from todolist,todo WHERE todo.idList = todolist.id AND todo.id = :id';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("isPublic Error");
        }
    }

    /**
     * Finds the idUser of a todo
     * @param int $id : L'identifiant de la todo
     * @return array
     * @throws Exception
     */
    function idOfUserOfTodo(int $id): array
    {
        try {
            $query = 'SELECT idUser from todolist,todo WHERE todo.idList = todolist.id AND todo.id = :id';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("idOfUserOfTodo Error");
        }
    }

    /**
     * Updates isDone of a todo
     * @param int $id
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function switchIsDone(int $id): bool
    {
        try {
            $query = 'UPDATE phptodolist.todo SET isDone = (NOT isDone) WHERE id=:id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("SwitchIsDone Error");
        }
    }

    /**
     * Updates isPublic of a todo
     * @param int $idList
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    public function switchIsPublic(int $idList): bool
    {
        try {
            $query = 'UPDATE phptodolist.todolist SET isPublic = (NOT isPublic) WHERE id=:idList';
            $param = [':idList' => [$idList, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("SwitchIsPublic Error");
        }
    }

    /**
     * Handles todos drag and drop from a list to another
     * @param int $idTodo
     * @param int $idNewList
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    public function dragDropTodo(int $idTodo, int $idNewList): bool
    {
        try {
            $query = 'UPDATE phptodolist.todo SET idList = :idNewList WHERE id = :idTodo';
            $param = [
                ':idNewList' => [$idNewList, PDO::PARAM_INT],
                ':idTodo' => [$idTodo, PDO::PARAM_INT]
            ];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("DragDropTodo Error");
        }
    }


    /**********************  **********************/
    /****************** NOT USED ******************/

    /**
     * NOT USED
     * Finds the todo of id $id
     * @param int $id
     * @return array
     * @throws Exception
     */
    function findTodo(int $id): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.todo WHERE id= :id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("Find Error");
        }
    }

    /**
     * NOT USED
     * Update la description d'une todo
     * @param int $id
     * @param string $description
     * @return bool : true on success, false otherwise
     * @throws Exception
     */
    function UpdateDesc(int $id, string $description): bool
    {
        try {
            $query = 'UPDATE phptodolist.todo SET description=:descript WHERE id=:id;';
            $param = [':id' => [$id, PDO::PARAM_INT],
                ':descript' => [$description, PDO::PARAM_STR]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("UpdateDesc Error");
        }
    }
}