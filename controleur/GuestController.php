<?php

namespace controleur;

use config\Sanitizer;
use config\Validation;
use config\ReturnENUM;
use Exception;
use modeles\ModeleTodo;
use modeles\ModeleUser;

/**
 * Class GuestController
 * @package controleur
 */
class GuestController
{
    /**
     * GuestController constructor.
     */
    public function __construct()
    {
        global $DATA_VUE;
        $DATA_VUE['page'] = "public";
    }

    /**
     * Displays public lists
     * @param array $params
     * @global array $vues
     * @global array $DATA_VUE
     * @global string $rep
     */
    public function publiclists(array $params): void
    {
        global $rep, $vues, $DATA_VUE;
        $DATA_VUE['page'] = "public";
        $mod = new ModeleTodo();
        $limit = 4;
        $page = isset($params[0]) ? $params[0] : 1;
        if (!Validation::validate_Int(intval($page))) {
            //la page n'est pas un int, donc la ressource est fausse
            $page = 1;
        }
        $tabLists = $mod->FindAllPublicLists($limit, ($page - 1) * $limit);
        $nbLists = $mod->countNbPublicLists();
        if($nbLists == ReturnENUM::WRONG_NB_LISTS){
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        $nbPages = ceil($nbLists / $limit);
        if ($nbPages == 0) {
            $nbPages = 1;
        }
        $url = $_SERVER['REQUEST_URI'];
        $url = Sanitizer::sanitize_String($url);
        $url = preg_replace('/\/[[:digit:]]*$/', '', $url);
        foreach ($tabLists as $list) {
            $list->setTodos($mod->FindAllTodosByListId($list->getId()));
        }
        require($rep.$vues['MainTodo']);
    }

    /**
     * Permet d'afficher la page de connexion.
     * @param array $params
     * @return void
     * @global string $rep
     * @global array $vues
     */
    public function signIn(array $params): void
    {
        global $rep, $vues;
        require($rep.$vues['signIn']);
    }

    /**
     * Permet de traiter la demande de connexion.
     * @param array $params
     * @return void
     * @global array $vues
     */
    public function connect(array $params): void
    {
        global $DATA_VUE, $vues, $ACTIVE_USER, $INIT_PARAMS;
        $user = null; // Will contain the instance corresponding to the connected user (if exists)
        if (!isset($ACTIVE_USER) || !isset($INIT_PARAMS) || !isset($DATA_VUE)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (isset($_POST['inputPseudo']) && isset($_POST['inputPassword'])) {
            $loginSanitized = Sanitizer::sanitize_String($_POST['inputPseudo']);
            $passwordSanitized = Sanitizer::sanitize_String($_POST['inputPassword']);
        } else {
            // Il faut afficher la page de connexion ici
            header('Location : /guest/signIn');
            return;
        }
        //Vérification de la taille du pseudo et du mot de passe :
        if (!Validation::val_pseudo_size($loginSanitized)) {
            $DATA_VUE['ERR_ps_pw'] = "pseudo length must be between " . $INIT_PARAMS['pseudoMinLen'] . ' and ' . $INIT_PARAMS['pseudoMaxLen'] . '.';
            require($vues['signIn']);
            return;
        } else if (!Validation::val_password_size($passwordSanitized)) {
            $DATA_VUE['ERR_ps_pw'] = "password length must be between " . $INIT_PARAMS['passwordMinLen'] . ' and ' . $INIT_PARAMS['passwordMaxLen'] . '.';
            require($vues['signIn']);
            return;
        }

        $mod = new ModeleUser();
        $res = $mod->connexion($loginSanitized, $passwordSanitized);
        switch ($res) {
            case ReturnENUM::OK:
                //S'il y a une erreur enregistrée, on la vide.
                if (isset($DATA_VUE['ERR_ps_pw'])) {
                    unset($DATA_VUE['ERR_ps_pw']);
                }
                //on redirige vers les listes privées, ou les logs si c'est un admin
                ($ACTIVE_USER['role'] === "admin") ? header('Location: /admin/logs') : header('Location: /user/privatelists/1');
                break;
            case ReturnENUM::WRONG_PASSWORD:
            case ReturnENUM::WRONG_PSEUDO:
                $DATA_VUE['ERR_ps_pw'] = 'wrong password or pseudo';
                require($vues['signIn']);
                break;
            default:
                ReturnENUM::handleEnum($res);
        }
    }

    /**
     * Switch a todo from isDone false/true to true/false
     * @param array $params
     * @global array $vues
     * @global array $ACTIVE_USER
     * @global string $rep
     */
    public function switchIsDone(array $params)
    {
        global $rep, $vues, $ACTIVE_USER;
        $mod = new ModeleTodo();
        $res = $mod->switchIsDone($_POST['idTodo']);
        ReturnENUM::handleEnum($res);
        header('Location: /guest/publiclists/' . ((isset($params[0])?$params[0]:1)));
    }

    /**
     * Permet de s'inscrire, si les variables en POST ne sont pas set, alors on affiche la page d'inscription, si elle sont set, on inscrit un nouvel utilisateur.
     * @param array $params
     * @return void
     * @global array $vues
     */
    public function inscription(array $params): void
    {
        global $vues, $DATA_VUE, $INIT_PARAMS;
        $mod = new ModeleUser();
        $pseudo = "";
        $password = "";
        $confirmPassword = "";
        //Verification que les variables sont def en POST :
        if (isset($_POST['inputPseudo']) && isset($_POST['inputPassword']) && isset($_POST['inputConfirmPassword'])) {
            //Récupération et nettoyage des données :
            $pseudo = Sanitizer::sanitize_String($_POST['inputPseudo']);
            $password = Sanitizer::sanitize_String($_POST['inputPassword']);
            $confirmPassword = Sanitizer::sanitize_String($_POST['inputConfirmPassword']);
        } else {
            require($vues['inscription']);
            return;
        }

        
        if (!isset($INIT_PARAMS) ||  !isset($DATA_VUE) || !isset($vues)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        //Vérification de la longueur du pseudo :
        if (!Validation::val_pseudo_size($pseudo)) {
            $DATA_VUE['ERR_pseudo'] = 'length between ' . $INIT_PARAMS['pseudoMinLen'] . '-' . $INIT_PARAMS['pseudoMaxLen'];
            require($vues['inscription']);
            return;
        }

        //Vérification de la longueur du mot de passe :
        if (!Validation::val_password_size($password) || !Validation::val_password_size($confirmPassword)) {
            $DATA_VUE['ERR_password'] = 'length between ' . $INIT_PARAMS['passwordMinLen'] . '-' . $INIT_PARAMS['passwordMaxLen'];
            $DATA_VUE['pseudoTMP'] = $pseudo;
            require($vues['inscription']);
            return;
        }

        if ($password !== $confirmPassword) {
            $DATA_VUE['ERR_password'] = 'must be the same';
            $DATA_VUE['pseudoTMP'] = $pseudo;
            require($vues['inscription']);
            return;
        }

        $res = $mod->inscription($pseudo, $password);
        
        switch ($res) {
            case ReturnENUM::OK:
                //Tout est ok, donc on le connect :
                $res = $mod->connexion($pseudo, $password);
                if ($res != ReturnENUM::OK) {
                    //Si ça se connecte pas, il y a une erreur dans le code !
                    ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
                    return;
                }
                header('Location: /user/privatelists/1');
                break;
            case ReturnENUM::PSEUDO_ALREADY_EXIST:
                $DATA_VUE['ERR_pseudo'] = 'already exists';
                $DATA_VUE['pseudoTMP'] = $pseudo;
                require($vues['inscription']);
                break;
            default:
                ReturnENUM::handleEnum($res);
        }
    }

    /**
     * Permet d'ajouter une liste publique.
     * Verification données : FAIT
     * Verification droits :
     * Verification syntaxe et propreté du code :
     * @param array $params
     * @return void
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function addPublicList(array $params): void
    {
        global $vues,$DATA_VUE, $INIT_PARAMS;
        if(!isset($_POST['listTitle']) || !isset($_POST['page'])){
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $titre = $_POST['listTitle'];
        $page = $_POST['page'];
        //Verification du numéro de page
        if (!Validation::validate_Int($page)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        //Verification du titre
        if ($titre != Sanitizer::sanitize_String($titre)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        //Vérification de la taille du titre de liste.
        if(!Validation::val_todoList_size($titre)){
            $DATA_VUE['alert'] = "The list's length must be between ".$INIT_PARAMS['titleMinLen']." and ".$INIT_PARAMS['titleMaxLen'].".";
            $this->publiclists($params);
            return;
        }

        $mod = new ModeleTodo();
        $res = $mod->createList($titre, true);
        ReturnENUM::handleEnum($res);
        header('Location: /guest/publiclists/' . $page);
    }

    /**
     * Permet de supprimer une liste publique. La fonction vérifie que la liste est bien une liste publique avant de la supprimer.
     * @param array $params
     * @return void
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function delPublicList(array $params): void
    {
        global $vues, $ACTIVE_USER;
        $mod = new ModeleTodo();
        //On vérifie que les variables sont initialisées
        if (isset($_POST) && isset($_POST['idList']) && isset($_POST['page'])) {
            //On vérifie que la liste est bien publique :
            $liste = $mod->FindListById(intval($_POST['idList']));
            if ($liste == null) {
                ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
                return;
            }
            if (!$liste->isPublic()) {
                ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
                return;
            }
            //On supprime la liste
            $res = $mod->deleteList(intval($_POST['idList']));
            ReturnENUM::handleEnum($res);
            //On redirige vers la page dans les listes publiques qui correspondent.
            header('Location: /guest/publiclists/' . $_POST['page']);
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
    }

    /**
     * Adds a todo in a public list
     * Vérification données : FAIT
     * Vérification que la liste existe : FAIT
     * Vérification de la taille de la description :
     * @param array $params
     * @return void
     * @global array $vues
     * @global array $ACTIVE_USER
     */
    public function addPublicTodo(array $params): void
    {
        global $vues,$INIT_PARAMS,$DATA_VUE;
        $mod = new ModeleTodo();
        if(!isset($INIT_PARAMS)){
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST['idList']) || !isset($_POST) || !isset($_POST['descript'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        //Verification des données en POST :
        $description = \config\Sanitizer::sanitize_String($_POST['descript']);
        $idListe = $_POST['idList'];

        //Validation de la taille de la description d'une todo.
        if(!Validation::val_todo_size($description)){
            $DATA_VUE['alert'] = "The todo's length mush be between ".$INIT_PARAMS['todoMinLen']." and ".$INIT_PARAMS['todoMaxLen'].".";
            $this->publiclists($params);
            return;
        }

        if (\config\Validation::validate_Int(intval($idListe))) {
            $liste = $mod->FindListById($idListe);
            if ($liste == null) {
                //La liste n'existe pas!
                ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
                return;
            }
            if ($liste->isPublic()) {
                $res = $mod->SaveATodo($description, $idListe);
                ReturnENUM::handleEnum($res);
                header('Location: /guest/publiclists/' .$params[0]);
            } else {
                ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
                return;
            }
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
    }

    /**
     * Permet de supprimer une Todo si elle est dans une liste publique.
     * @param array $params
     * @return void
     */
    public function delPublicTodo(array $params): void
    {
        if (!isset($_POST['idTodo'])) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $idOfTodo = $_POST['idTodo'];
        if (!Validation::validate_Int($idOfTodo)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_400);
            return;
        }
        $mod = new ModeleTodo();
        if ($mod->isTodoPublic($idOfTodo)) {
            $res = $mod->deleteTodo($idOfTodo);
            ReturnENUM::handleEnum($res);
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        header('Location: /guest/publiclists/' .((isset($params[0])?$params[0]:1)));
    }

    /**
     * permet d'éditer le titre d'une liste
     * @param array $params
     * @return void
     * @global array $ACTIVE_USER
     */
    public function showPublicEditTitle(array $params): void
    {
        global $ACTIVE_USER, $DATA_VUE;
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($DATA_VUE)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST) || !isset($_POST['idList'])) {
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
        if ($liste->getIdUser() != $ACTIVE_USER['uid'] && $liste->getIdUser() != 0) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }
        $DATA_VUE['isEditTitle'] = $liste->getId();
        $this->publiclists($params);
    }

    /**
     * Permet d'éditer le titre d'une liste
     * @param array $params
     * @return void
     * @global array $ACTIVE_USER
     * @global array $DATA_VUE
     */
    public function publicEditTitle(array $params): void
    {
        global $ACTIVE_USER, $DATA_VUE, $INIT_PARAMS;
        if (!isset($ACTIVE_USER) || !isset($ACTIVE_USER['uid']) || !isset($DATA_VUE)) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if (!isset($_POST) || !isset($_POST['idList'])) {
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
        if ($liste->getIdUser() != $ACTIVE_USER['uid'] && $liste->getIdUser() != 0) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_403);
            return;
        }

        if (!Validation::val_todoList_size($newTitle)) {
            //trop long ou trop court !
            $DATA_VUE['alert']="The title's length mush be between" . $INIT_PARAMS['titleMinLen'] . " and " . $INIT_PARAMS['titleMaxLen'] . ".";
            $this->publiclists($params);
            return;
        }

        $res = $mod->changeListName($idList, $newTitle);
        if ($res == ReturnENUM::OK) {
            header('Location: /guest/publiclists/' .((isset($params[0])?$params[0]:1)));
        } else {
            ReturnENUM::handleEnum($res);
        }
    }

    /**
     * Allows the user to drag and drop a todo from a list to another
     * @param array $params
     * @return void
     */
    public function dragDropTodo(array $params): void
    {
        global $ACTIVE_USER, $DATA_VUE;
        $idTodo = isset($params[0]) ? $params[0] : null;
        $idNewList = isset($params[1]) ? $params[1] : null;
        if (!Validation::validate_Int(intval($idTodo)) || !Validation::validate_Int(intval($idNewList))) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $mod = new ModeleTodo();
        $res = $mod->dragDropTodo($idTodo, $idNewList);
        ReturnENUM::handleEnum($res);
        if (!$mod->FindListById($idNewList)->isPublic()) {
            header('Location: /user/privatelists/');
        } else {
            header('Location: /guest/publiclists/');
        }
    }
}
