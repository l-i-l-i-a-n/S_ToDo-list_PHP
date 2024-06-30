<?php

namespace modeles;

use DAL\Connexion;
use DAL\TodoGateway;
use DAL\TodoListGateway;
use Exception;
use config\ReturnENUM;

/**
 * Class ModeleTodo
 * @package modeles
 */
class ModeleTodo
{
    /**
     * ModeleTodo constructor.
     */
    public function __construct()
    {

    }

    /**
     * Inserts a new todo in the list of id $idList
     * @param string $descript
     * @param int $idList
     * @return string
     */
    public function SaveATodo(string $descript, int $idList): string
    {
        try {
            $tgw = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $tgw->insertTodo($descript, $idList);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Finds the list with the given id
     * @param int $idList
     * @return TodoList
     */
    public function FindListById(int $idList): TodoList
    {
        if (!isset($idList)) {
            return null;
        }
        try {
            $listGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $results = $listGateway->findListById($idList);
            $factory = new TodoListFactory();
            return $factory->createTodolists($results, 'mysql')[0];
        } catch (Exception $e) {
            return ReturnENUM::NULL;
        }
    }

    /**
     * Finds all public lists
     * @param $limit
     * @param $offset
     * @return array
     */
    public function FindAllPublicLists(int $limit, int $offset): array
    {
        try {
            $listGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $results = $listGateway->FindAllPublicLists($limit, $offset);
            $factory = new TodoListFactory();
            return $factory->createTodolists($results, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }

    /**
     * Finds all the lists the belong to the given user id
     * @param int $limit
     * @param int $offset
     * @param int $idUser
     * @return array
     */
    public function FindAllUserLists(int $limit, int $offset, int $idUser): array
    {
        try {
            $listGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $results = $listGateway->FindAllUserLists($limit, $offset, $idUser);
            $factory = new TodoListFactory();
            return $factory->createTodolists($results, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }

    /**
     * Finds all the todos in the list of id $idList
     * @param int $idList
     * @return array
     */
    public function FindAllTodosByListId(int $idList): array
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $results = $todoGateway->FindAllTodosByListId($idList);
            $factory = new TodoFactory();
            return $factory->createTodos($results, 'mysql');
        } catch (Exception $e) {
            return ReturnENUM::EMPTY_ARRAY;
        }
    }

    /**
     * Deletes a todo
     * @param int $idTodo
     * @return string
     */
    public function deleteTodo(int $idTodo): string
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoGateway->deleteTodo($idTodo);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Checks if a todo belongs to a user
     * @param int $idTodo
     * @return bool
     */
    public function isTodoPublic(int $idTodo): bool
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $res = $todoGateway->isPublic($idTodo)[0];
        } catch (Exception $e) {
            return ReturnENUM::FALSE;
        }
        if (!isset($res) || empty($res)) {
            return false;
        }
        return $res['isPublic'];
    }

    /**
     * Checks if a todo belongs to a user
     * @param int $idTodo
     * @param int $idUser
     * @return bool
     */
    public function isTodoOfUser(int $idTodo, int $idUser): bool
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $res = $todoGateway->idOfUserOfTodo($idTodo)[0];
        } catch (Exception $e) {
            return ReturnENUM::FALSE;
        }
        if (!isset($res) || empty($res)) {
            return false;
        }
        if (($res['idUser']) == $idUser) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Handles the deletion of a list
     * @param int $idList
     * @return string
     */
    public function deleteList(int $idList): string
    {
        try {
            $todoListGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoListGateway->deleteList($idList);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Handles the creation of a new list
     * @param string $titleList
     * @param bool $isPublic
     * @return string
     */
    public function createList(string $titleList, bool $isPublic): string
    {
        global $ACTIVE_USER;
        $idUser = 0;
        if (isset($isPublic) && isset($ACTIVE_USER)) {
            if (!$isPublic) {
                $idUser = $ACTIVE_USER['uid'];
            }
        } else
            return ReturnENUM::ERROR_404;
        try {
            $todoListGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoListGateway->insertList($titleList, $idUser);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Handles the is done switch of a todo
     * @param int $idTodo
     * @return string
     */
    public function switchIsDone(int $idTodo): string
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoGateway->switchIsDone($idTodo);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Counts the number of public lists
     * @return int
     */
    public function countNbPublicLists(): int
    {
        try {
            $todoListGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            return $todoListGateway->countNbPublicLists()[0][0];
        } catch (Exception $e) {
            ReturnENUM::WRONG_NB_LISTS;
        }
        return ReturnENUM::WRONG_NB_LISTS;
    }

    /**
     * Counts the number of list belonging to the given user
     * @param int $idUser
     * @return int The number of lists
     */
    public function countNbUserLists(int $idUser): int
    {
        try {
            $todoListGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            return $todoListGateway->countNbUserLists($idUser)[0][0];
        } catch (Exception $e) {
            ReturnENUM::WRONG_NB_LISTS;
        }
        return ReturnENUM::ERROR_500;
    }

    /**
     * Handles the is public modification of a list
     * @param int $idList
     * @return string
     */
    public function switchIsPublic(int $idList): string
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoGateway->switchIsPublic($idList);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Handles listname change
     * @param int $idList
     * @param string $newName
     * @return string
     */
    public function changeListName(int $idList, string $newName): string
    {
        try {
            $todoListGateway = new TodoListGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoListGateway->updateTitle($idList, $newName);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }


    /**
     * Handles todos drag and drop from a list to another
     * @param int $idTodo
     * @param int $idNewList
     * @return string
     */
    public function dragDropTodo(int $idTodo, int $idNewList): string
    {
        try {
            $todoGateway = new TodoGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $ok = $todoGateway->dragDropTodo($idTodo, $idNewList);
            if (!$ok) return ReturnENUM::ERROR_500;
            return ReturnENUM::OK;
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }
}