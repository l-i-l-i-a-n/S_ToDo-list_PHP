<?php

namespace DAL;

use Exception;
use PDO;
use PDOException;

/**
 * Class UserGateway
 * @package DAL
 */
class UserGateway
{
    /**
     * The Connection class instance
     * @var Connexion
     */
    private Connexion $co;

    /**
     * UserGateway constructor.
     * @param Connexion $connexion
     */
    public function __construct(Connexion $connexion)
    {
        $this->co = $connexion;
    }

    /**
     * Finds the user corresponding to the given id, in the user table
     * @param int $id : The searched user id
     * @return array Returns an array containing the results of the query (on success: a unique user)
     * @throws Exception
     */
    public function findUserById(int $id): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.user WHERE id = :id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("findUserById Error");
        }
    }

    /**
     * Finds the user corresponding to the given pseudo, in the user table
     * @param string $pseudo : The searched user pseudo
     * @return array Returns an array containing the results of the query (on success: a unique user)
     * @throws Exception
     */
    public function findUserByPseudo(string $pseudo): array
    {
        try {
            $query = 'SELECT * FROM phptodolist.user WHERE pseudo = :pseudo;';
            $param = [':pseudo' => [$pseudo, PDO::PARAM_STR]];
            $this->co->executeQuery($query, $param);
            return $this->co->getResults();
        } catch (PDOException $ex) {
            throw new Exception("findUserByPseudo Error");
        }
    }

    /**
     * Inserts a new user in the user table, with the given parameters as attributes
     * @param string $pseudo : New user pseudo
     * @param string $password : New user password
     * @return bool Returns `true` on success, `false` otherwise
     * @throws Exception
     */
    public function insertUser(string $pseudo, string $password): bool
    {
        try {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $query = 'INSERT INTO phptodolist.user VALUES(NULL, :pseudo, :pass, false);';
            $param = [':pseudo' => [$pseudo, PDO::PARAM_STR], ':pass' => [$pass, PDO::PARAM_STR]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("insertUser Error");
        }
    }

    /**
     * Deletes the user corresponding to the given id from the user table
     * @param int $id : The user id in the database
     * @return bool Returns `true` on success, `false` otherwise
     * @throws Exception
     */
    public function deleteUserById(int $id): bool
    {
        try {
            $query = 'DELETE FROM phptodolist.user WHERE id = :id;';
            $param = [':id' => [$id, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (PDOException $ex) {
            throw new Exception("deleteUserById Error");
        }
    }

    /**
     * NOT USED
     * Deletes the user corresponding to the given pseudo from the user table
     * @param string $pseudo : The user pseudo in the database
     * @return bool Returns `true` on success, `false` otherwise
     * @throws Exception
     */
    public function deleteUserByPseudo(string $pseudo): bool
    {
        try {
            $query = 'DELETE FROM phptodolist.user WHERE pseudo = :pseudo;';
            $param = [':pseudo' => [$pseudo, PDO::PARAM_STR]];
            $this->co->executeQuery($query, $param);
            return true;
        } catch (PDOException $ex) {
            throw new Exception("deleteUserByPseudo Error");
        }
    }

    /**
     * Updates the pseudo of the user of id $id
     * @param int $id : The user id
     * @param string $pseudo : The new pseudo
     * @return bool : True on success, false otherwise
     * @throws Exception
     */
    public function updateUserPseudo(int $id, string $pseudo): bool
    {
        try {
            $query = 'UPDATE phptodolist.user SET pseudo = :pseudo WHERE id = :id;';
            $param = [':pseudo' => [$pseudo, PDO::PARAM_STR],
                ':id' => [$id, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (Exception $ex) {
            throw new Exception("updateUserPseudo error");
        }
    }

    /**
     * Updates the password of the user of id $id
     * @param int $id
     * @param string $password
     * @return bool : True on success, false otherwise
     * @throws Exception
     */
    public function updateUserPassword(int $id, string $password): bool
    {
        try {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $query = 'UPDATE phptodolist.user SET password =:mdp WHERE id = :id;';
            $param = [':mdp' => [$pass, PDO::PARAM_STR],
                ':id' => [$id, PDO::PARAM_INT]];
            return $this->co->executeQuery($query, $param);
        } catch (Exception $ex) {
            throw new Exception("updateUserPassword error");
        }
    }
}