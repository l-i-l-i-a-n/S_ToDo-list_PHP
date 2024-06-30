<?php

namespace modeles;

use DAL\UserGateway;
use Exception;
use config\ReturnENUM;
use DAL\Connexion;

class ModeleUser
{
    /**
     * ModeleUser constructor.
     */
    public function __construct()
    {
    }

    /**
     * Allows to insert a new user in the database
     * @param string $pseudo
     * @param string $password
     * @return string // Corresponds to a ReturnENUM constant.
     */
    public function inscription(string $pseudo, string $password): string
    {
        if (!isset($pseudo) || !isset($password)) {
            return ReturnENUM::ERROR_500;
        }
        try {
            $ugw = new UserGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
            $res = $ugw->findUserByPseudo($pseudo);
            if ($res != null || !empty($res)) {
                return ReturnENUM::PSEUDO_ALREADY_EXIST;
            } else {
                $ok = $ugw->insertUser($pseudo, $password);
                if ($ok) {
                    return ReturnENUM::OK;
                } else {
                    return ReturnENUM::NOT_OK;
                }
            }
        } catch (Exception $e) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Handles user sign in
     * Called from the connexion form, verifies if the user exists
     * @param string $pseudo
     * @param string $password // The given password
     * @return string // Corresponds to a ReturnENUM variable.
     */
    public function connexion(string $pseudo, string $password): string
    {
        global $ACTIVE_USER;
        if (isset($pseudo) && isset($password)) {
            // prevents from signing in to the public user
            if ($pseudo == 'public') {
                return ReturnENUM::WRONG_PSEUDO;
            }
            try {
                $ugw = new UserGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
                $res = $ugw->findUserByPseudo($pseudo);
            } catch (Exception $e) {
                return ReturnENUM::ERROR_500;
            }
        } else {
            return ReturnENUM::ERROR_500;
        }
        if (isset($res[0])) {
            //On créé un user temporaire, résultant de notre requête dans la BD
            $user = UserFactory::createUser($res, "mysql");
            if (password_verify($password, $user->getPassword())) {
                $_SESSION['uid'] = $user->getId();
                $_SESSION['login'] = $pseudo;
                $ACTIVE_USER['uid'] = $user->getId();
                $ACTIVE_USER['login'] = $pseudo;
                if ($user->isAdmin()) {
                    $_SESSION['role'] = 'admin';
                    $ACTIVE_USER['role'] = 'admin';
                } else {
                    $_SESSION['role'] = 'user';
                    $ACTIVE_USER['role'] = 'user';
                }
                return ReturnENUM::OK;
            } else {
                return ReturnENUM::WRONG_PASSWORD;
            }
        } else {
            return ReturnENUM::WRONG_PSEUDO;
        }
    }

    /**
     * Deletes a user from the database
     * @param int $id
     * @return string // Corresponds to a ReturnENUM variable.
     */
    public function delete(int $id): string
    {
        $ugw = new UserGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
        try {
            $res = $ugw->findUserById($id);
            if (isset($res[0]) && $res[0] != null) {
                $ugw->deleteUserById($id);
                return ReturnENUM::OK;
            }
        } catch (Exception $ex) {
            return ReturnENUM::ERROR_500;
        }
        return ReturnENUM::NOT_OK;
    }

    /**
     * Updates the pseudo of the user of id $idUser
     * @param int $idUser
     * @param string $pseudo
     * @return string // Corresponds to a ReturnENUM variable.
     * @global array $ACTIVE_USER
     */
    public function updatePseudo(int $idUser, string $pseudo): string
    {
        global $ACTIVE_USER;
        $ugw = new UserGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid'])) {
            return ReturnENUM::ERROR_500;
        }
        try {
            $user = UserFactory::createUser($ugw->findUserById($idUser), 'mysql');
            if ($user != null) {
                if ($user->getId() == $ACTIVE_USER['uid'] || !isset($idUser) || !isset($pseudo)) {
                    $ok = $ugw->updateUserPseudo($idUser, $pseudo);
                    if ($ok) {
                        //tout s'est bien passé
                        return ReturnENUM::OK;
                    } else {
                        //probleme serveur
                        return ReturnENUM::ERROR_500;
                    }
                } else {
                    //l'utilisateur demande de modifier le pseudo d'un autre utilisateur !
                    return ReturnENUM::ERROR_403;
                }
            } else {
                //user est null
                return ReturnENUM::ERROR_400;
            }
        } catch (Exception $ex) {
            return ReturnENUM::ERROR_500;
        }
    }

    /**
     * Updates the password of the user of id $idUser
     * @param int $idUser
     * @param string $password
     * @return string // Corresponds to a ReturnENUM variable.
     * @global array $ACTIVE_USER
     */
    public function updatePassword(int $idUser, string $password): string
    {
        global $ACTIVE_USER;
        $ugw = new UserGateway(new Connexion($GLOBALS['dsn'], $GLOBALS['username'], $GLOBALS['password']));
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($idUser) || !isset($password)) {
            return ReturnENUM::ERROR_500;
        }
        try {
            $user = UserFactory::createUser($ugw->findUserById($idUser), 'mysql');
            if ($user != null) {
                if ($user->getId() == $ACTIVE_USER['uid']) {
                    $ok = $ugw->updateUserPassword($idUser, $password);
                    if ($ok) {
                        //tout s'est bien passé
                        return ReturnENUM::OK;
                    } else {
                        //probleme serveur
                        return ReturnENUM::ERROR_500;
                    }
                } else {
                    //l'utilisateur demande de modifier le mot de passe d'un autre utilisateur !
                    return ReturnENUM::ERROR_403;
                }
            } else {
                //user est null
                return ReturnENUM::ERROR_400;
            }
        } catch (Exception $ex) {
            return ReturnENUM::ERROR_500;
        }
    }
}
