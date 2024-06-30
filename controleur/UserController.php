<?php

namespace controleur;

use config\Validation;
use config\Sanitizer;
use config\ReturnENUM;
use Exception;
use modeles\ModeleTodo;
use modeles\ModeleUser;
use PDOException;

class UserController
{
    /**
     * Constructeur de UserController.
     * @global type $rep
     * @global type $vues
     * @global string $DATA_VUE
     */
    public function __construct()
    {
        global $rep, $vues, $DATA_VUE;
        $DATA_VUE['page'] = "private";
    }

    /**
     * Permet de se déconnecter
     * @global type $vues
     * @global array $ACTIVE_USER
     */
    public function disconnect()
    {
        global $vues, $ACTIVE_USER;

        if ($ACTIVE_USER['role'] == 'guest') {
            require($vues['goToConnexion']);
            header('Location: /guest/signIn/');
        }

        // reinitialisation du tableau dans la session
        $_SESSION = array();
        // Destruction de la session
        session_destroy();
        // Destruction du tableau de session
        unset($_SESSION);

        $ACTIVE_USER = array();
        $ACTIVE_USER['uid'] = 0;
        $ACTIVE_USER['role'] = 'guest';
        header('Location: /');
    }

    /**
     * Permet d'afficher la liste de lists privées.
     * @param type $params
     * @global type $vues
     * @global string $DATA_VUE
     * @global type $rep
     */
    public function privatelists($params)
    {
        global $rep, $vues, $DATA_VUE, $ACTIVE_USER;
        $DATA_VUE['page'] = "private";
        $mod = new ModeleTodo();
        $limit = 4;
        $page = isset($params[0]) ? $params[0] : 1;
        if (!Validation::validate_Int(intval($page))) {
            $page = 1;
        }
        $tabLists = $mod->FindAllUserLists($limit, ($page - 1) * $limit, $ACTIVE_USER['uid']);
        $nbLists = $mod->countNbUserLists($ACTIVE_USER['uid']);
        $nbPages = ceil($nbLists / $limit);
        if ($nbPages == 0){
            $nbPages = 1;
        }
        $url = $_SERVER['REQUEST_URI'];
        $url = Sanitizer::sanitize_String($url);
        $url = preg_replace('/\/[[:digit:]]*$/', '', $url);
        
        foreach ($tabLists as $list) {
            $list->setTodos($mod->FindAllTodosByListId($list->getId()));
        }
        require($rep . $vues['MainTodo']);
        
    }

    /**
     * Permet d'afficher la page de compte. La fonction vérifie s'il y a un message qui a été posé dans la Session. S'il y en a un, elle le nettoie et le mets dans $DATA_VUE.
     * @param type $params
     * @return void
     * @global type $vues
     * @global string $DATA_VUE
     */
    public function account($params)
    {
        global $vues, $DATA_VUE;
        if (isset($DATA_VUE) && isset($_SESSION) && isset($_SESSION['accountAlert']) && !empty($_SESSION['accountAlert'])) {
            $accountAlert = Sanitizer::sanitize_String($_SESSION['accountAlert']);
            $DATA_VUE['accountAlert'] = $accountAlert;
            //on vide la variable temporaire de session :
            $_SESSION['accountAlert'] = "";
            unset($_SESSION['accountAlert']);
        }
        $DATA_VUE['page'] = "account";
        require($vues['accountPage']);
        return;
    }

    /**
     * Permet d'afficher la page de confirmation de suppression.
     * @param type $params
     * @return void
     * @global type $vues
     */
    public function deleteConfirmation($params): void
    {
        global $vues;
        require($vues['deleteConfirmation']);
        return;
    }

    /**
     * Permet de supprimer son compte!
     * @param type $params
     * @return void
     * @global type $vues
     * @global array $ACTIVE_USER
     */
    public function deleteAccount($params): void
    {
        global $vues, $ACTIVE_USER;
        //vérification que l'utilisateur n'est pas un guest ou que son identifiant n'est pas 0:
        if ($ACTIVE_USER['role'] == 'guest' || $ACTIVE_USER['uid'] == 0) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleUser();
        $identifiant = $ACTIVE_USER['uid'];
        $res = $mod->delete($identifiant);
        if ($res != ReturnENUM::OK) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        $this->disconnect();
    }

    /**
     * Permet d'ajouter une liste privée.
     *
     * Verification données : FAIT
     * Verification droits : FAIT
     * Verification syntaxe et propreté du code :
     * @param array $params
     * @return void
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function addPrivateList($params): void
    {
        global $vues, $ACTIVE_USER;
        echo 'inAddPrivateList';

        if (!isset($_POST['page']) || !isset($_POST['listTitle'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['role'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if ($ACTIVE_USER['role'] != 'user' && $ACTIVE_USER['role'] != 'admin') { //Verification que l'utilisateur est bien connecté
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        $numPage = $_POST['page'];
        $titre = $_POST['listTitle'];
        //Verification du numéro de page
        if (!Validation::validate_Int($numPage)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        //Vérification du titre.
        if ($titre != Sanitizer::sanitize_String($titre)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $mod = new ModeleTodo();
        $res = $mod->createList($titre, false);
        ReturnENUM::handleEnum($res);
        header('Location: /user/privatelists/' . $numPage);
    }

    /**
     * Permet de supprimer une liste privée. La fonction vérifie si l'utilisateur a bien le droit de supprimer cette liste précise.
     * @param array $params
     * @return void
     * @global array $ACTIVE_USER
     * @global array $vues
     */
    public function delPrivateList(array $params): void
    {
        global $vues, $ACTIVE_USER;
        if (!isset($_POST) || !isset($_POST['idList']) || !isset($_POST['page'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if ($ACTIVE_USER['role'] != 'user' && $ACTIVE_USER['role'] != 'admin') {
            header('Location: /guest/publiclists/');
            return;
        }
        $idList = $_POST['idList'];
        $page = $_POST['page'];
        if(!Validation::validate_Int($idList) || !Validation::validate_Int($page)){
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        $liste = $mod->FindListById($idList);
        //Si la liste n'existe pas :
        if ($liste == null) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        //Si la liste n'appartient pas à l'utilisateur connecté au site :
        if ($liste->getIdUser() != $ACTIVE_USER['uid']) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        $res = $mod->deleteList($idList);
        ReturnENUM::handleEnum($res);
        header('Location: /user/privatelists/' . $page);
    }

    /**
     * Permet d'ajouter une Todo dans une liste privée.
     * Vérification des données : FAIT
     * Vérification que la liste existe : FAIT
     * Vérification de la taille de descript :
     * @param array $params
     * @return void
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function addPrivateTodo(array $params): void
    {
        global $vues, $ACTIVE_USER,$INIT_PARAMS,$DATA_VUE;
        $mod = new ModeleTodo();
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if (!isset($_POST['idList']) || !isset($_POST) || !isset($_POST['descript'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        //Verification des données en POST :
        $description = Sanitizer::sanitize_String($_POST['descript']);
        $idListe = $_POST['idList'];

        if(!Validation::val_todo_size($description)){
            $DATA_VUE['alert'] = "The todo's length mush be between ".$INIT_PARAMS['todoMinLen']." and ".$INIT_PARAMS['todoMaxLen'].".";
            $this->privatelists($params);
            return;
        }
        if (Validation::validate_Int(intval($idListe))) {
            $liste = $mod->FindListById($idListe);
            if ($liste == null) {
                //La liste n'existe pas!
                ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
                return;
            }
            if ($liste->getIdUser() == $ACTIVE_USER['uid']) {
                $res = $mod->SaveATodo($description, $idListe);
                ReturnENUM::handleEnum($res);
                header('Location: /user/privatelists/'.((isset($params[0]))?$params[0]:"1"));
                return;
            } else {
                ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
                return;
            }
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
    }

    
    /**
     * Permet de mettre à jour le peudo de l'utilisateur
     * @global \controleur\type $vues
     * @global array $ACTIVE_USER
     * @global string $DATA_VUE
     * @global \controleur\type $INIT_PARAMS
     * @param type $params
     * @return void
     */
    public function updatePseudo($params):void
    {
        global $vues, $ACTIVE_USER, $DATA_VUE, $INIT_PARAMS;
        $mod = new ModeleUser();
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($INIT_PARAMS) || !isset($INIT_PARAMS['pseudoMinLen']) || !isset($INIT_PARAMS['pseudoMaxLen'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST['inputPseudo'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
        }
        //Modification de pseudo
        $pseudo = $_POST['inputPseudo'];
        //Vérification du pseudo :
        if ($pseudo != Sanitizer::sanitize_String($pseudo)) {
            require($vues['400error']);
            return;
        }
        //Verification du pseudo :
        if (!Validation::val_pseudo_size($pseudo)) {
            $DATA_VUE['pseudoERR'] = "length between : " . $INIT_PARAMS['pseudoMinLen'] . '-' . $INIT_PARAMS['pseudoMaxLen'];
            require($vues['accountPage']);
            return;
        }
        $res = $mod->updatePseudo($ACTIVE_USER['uid'], $pseudo);
        if ($res == ReturnENUM::OK) {
            //TOUT est ok !
            $_SESSION['login'] = $pseudo;
            $_SESSION['accountAlert'] = "Pseudo has been modified!";
            header('Location: /user/account');
            return;
        } else {
            ReturnENUM::handleEnum($res);
            return;
        }
    }
    
    /**
     * Permet de mettre à jour le mot de passe de l'utilisateur
     * Vérification des données :
     * Vérification longueur mdp :
     * Vérification longueur pseudo :
     * @param array $params
     * @return void
     * @global string $DATA_VUE
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function updatePassword($params): void
    {
        global $vues, $ACTIVE_USER, $DATA_VUE, $INIT_PARAMS;
        $mod = new ModeleUser();
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($INIT_PARAMS) || !isset($INIT_PARAMS['pseudoMinLen']) || !isset($INIT_PARAMS['pseudoMaxLen'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (isset($_POST) && isset($_POST['inputPassword']) && isset($_POST['inputPasswordConf'])) {
            if (!isset($INIT_PARAMS['passwordMinLen']) || !isset($INIT_PARAMS['passwordMaxLen'])) {
                ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
                return;
            }
            //Modification de password
            $pass = Sanitizer::sanitize_String($_POST['inputPassword']);
            $passConf = Sanitizer::sanitize_String($_POST['inputPasswordConf']);
            if (!Validation::val_password_size($pass) || !Validation::val_password_size($passConf)) {
                $DATA_VUE['passwordERR'] = 'length between ' . $INIT_PARAMS['passwordMinLen'] . '-' . $INIT_PARAMS['passwordMaxLen'];
                require($vues['accountPage']);
                return;
            }
            if ($pass == $passConf) {
                $res = $mod->updatePassword($ACTIVE_USER['uid'], $pass);
                if ($res == ReturnENUM::OK) {
                    //tout est ok
                    $_SESSION['accountAlert'] = " Le mot de passe a bien été modifié !";
                    header('Location: /user/account');
                    return;
                } else {
                    ReturnENUM::handleEnum($res);
                    return;
                }
            } else {
                //Les mdp sont différents : afficher message d'erreur !
                $DATA_VUE['passwordERR'] = 'Non identique';
                require($vues['accountPage']);
                return;
            }
        } else {
            //aucune variables dans POST qui nous interesse !
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
    }

    /**
     * Permet de supprimer une Todo dans une liste privée
     * @param type $params
     * @return void
     * @global type $vues
     * @global type $ACTIVE_USER
     */
    public function delPrivateTodo($params): void
    {
        global $ACTIVE_USER;
        if (!isset($_POST) || !isset($_POST['idTodo'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $idOfTodo = $_POST['idTodo'];
        if (!Validation::validate_Int($idOfTodo)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        if ($mod->isTodoOfUser($idOfTodo, $ACTIVE_USER['uid'])) {
            $res = $mod->deleteTodo($idOfTodo);
            ReturnENUM::handleEnum($res);
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        header('Location: /user/privatelists/' . ((isset($params[0])?$params[0]:1)));
    }

    /**
     * Permet de switcher une Todo Privée, vérifie si on a bien le droit d'accéder à la todo.
     * @param type $params
     * @return void
     */
    public function switchIsDonePrivate($params): void
    {
        global $ACTIVE_USER;
        if (!isset($_POST['idTodo'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $idOfTodo = $_POST['idTodo'];
        if (!Validation::validate_Int($idOfTodo)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        if ($mod->isTodoOfUser($idOfTodo, $ACTIVE_USER['uid'])) {
            $res = $mod->switchIsDone($idOfTodo);
            ReturnENUM::handleEnum($res);
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        header('Location: /user/privatelists/' .((isset($params[0]))?$params[0]:1));
    }


    /**
     * Permet de switcher le isPublic d'une todoList privée.
     * @param type $params
     * @return type
     * @global array $ACTIVE_USER
     */
    public function switchIsPublic($params)
    {
        global $ACTIVE_USER;
        if (!isset($_POST['idList'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        $idList = $_POST['idList'];
        if (!Validation::validate_Int($idList)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        $res = $mod->switchIsPublic($idList);
        ReturnENUM::handleEnum($res);
        header('Location: /user/privatelists/'.((isset($params[0]))?$params[0]:1));
    }

    /**
     * Permet d'afficher la barre de modification du titre d'une liste privée.
     * @param type $params
     * @return void
     * @global array $ACTIVE_USER
     * @global string $DATA_VUE
     */
    public function showPrivateEditTitle($params): void
    {
        global $ACTIVE_USER, $DATA_VUE;
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($DATA_VUE)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST['idList'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $idList = $_POST['idList'];
        if (!Validation::validate_Int($idList)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        $liste = $mod->FindListById($idList);
        if ($liste->getIdUser() != $ACTIVE_USER['uid']) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }

        $DATA_VUE['isEditTitle'] = $liste->getId();
        $this->privatelists($params);
    }

    /**
     * Permet de modifier le titre d'une liste privée.
     * @param type $params
     * @return void
     * @global type $INIT_PARAMS
     * @global array $ACTIVE_USER
     * @global string $DATA_VUE
     */
    public function privateEditTitle($params): void
    {
        global $ACTIVE_USER, $DATA_VUE, $INIT_PARAMS;
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($DATA_VUE)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST['idList'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $idList = $_POST['idList'];
        $newTitle = Sanitizer::sanitize_String($_POST['title']);
        if (!Validation::validate_Int($idList)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        $liste = $mod->FindListById($idList);
        if ($liste->getIdUser() != $ACTIVE_USER['uid']) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        
        if (!Validation::val_todoList_size($newTitle)) {
            //trop long ou trop court !
            $DATA_VUE['alert'] = "The list's length must be between ".$INIT_PARAMS['titleMinLen']." and ".$INIT_PARAMS['titleMaxLen'].".";
            $this->privatelists($params);
            return;
        }

        $res = $mod->changeListName($idList, $newTitle);
        if ($res == ReturnENUM::OK) {
            header('Location: /user/privatelists/'.((isset($params[0]))?$params[0]:1));
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
        }
    }
}
