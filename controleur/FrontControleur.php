<?php

namespace controleur;

use config\Validation;
use config\Sanitizer;
use controleur\GuestController;
use config\ReturnENUM;
use controleur\UserController;
use Router;

class FrontControleur
{
    private $EXPLODED_REQUEST = [];
    private $Acteurs = [];
    private $listeActions = [];
    private $listeCtrl = [];
    private $PARAMS = [];

    public function __construct()
    {
        global $vues;
        $localACTOR = "";
        $localACTION = "";
        $this->Acteurs= array('guest','user','admin');
        $this->listeActions=array(
        'guest' => array ('showPublicEditTitle','publicEditTitle','switchIsDone','inscription','addPublicList','delPublicList','addPublicTodo','delPublicTodo','connect','signIn','publiclists', 'dragDropTodo'),
        'user' => array ('showPrivateEditTitle','privateEditTitle','switchIsDonePrivate','privatelists','disconnect','addPrivateList','delPrivateList','addPrivateTodo','delPrivateTodo','account','deleteConfirmation','deleteAccount','updatePassword','updatePseudo','switchIsPublic'),
        'admin' => array('logs'));

        $this->listeCtrl = array('guest' => 'GuestController',
            'user' => 'UserController',
            'admin' => 'AdminController');

        $request = $_SERVER['REQUEST_URI'];
        if (!Validation::validate_uri($request)) {
            $this->errorPage();
        }
        //On calcule le nombre de champs dans l'URI
        if ($request != '' && $request != '/') {
            $this->EXPLODED_REQUEST = explode('/', $request);
        }
        $localNombreDeChamps = count($this->EXPLODED_REQUEST);

        $params = [];
        for ($i = 0; $i < count($this->EXPLODED_REQUEST); $i++) {
            Sanitizer::sanitize_String($this->EXPLODED_REQUEST[$i]);
        }

        /*
         * On regarde s'il y a 1 ou + de champs:
         *      Si oui :
         *          verif qu'il y a deux champs ou plus :
         *              Si oui:
         *                  verif du user
         *                  verif de l'action
         *              Si non:
         *                  //il y a juste l'acteur
         *                  "/guest" => affichage page publique listes
         *                  "/user" => soit private liste (si co) soit pageConnexion (si pas co)
         *      Si non :
         *          "" ou "/" : page d'acceuil
         */
        //echo 'CHAMPS NOMBRE : '.$localNombreDeChamps;
        if ($localNombreDeChamps >= 1) {
            //echo '</br>CHAMP >= 1';
            if ($localNombreDeChamps > 2) {
                //verification de l'acteur
                if ($this->actorVerificator($this->EXPLODED_REQUEST[1])) {
                    $localACTOR = $this->EXPLODED_REQUEST[1];
                } else {
                    $localACTOR = "none";
                }
                //verification de l'action
                //echo '</br>VERIF ACTION';
                if ($this->actionVerificator($localACTOR, $this->EXPLODED_REQUEST[2])) {
                    $localACTION = $this->EXPLODED_REQUEST[2];
                    //echo '</br>ACTION EXISTE';
                } else {
                    $localACTION = "none";
                }
            } else {
                if ($this->EXPLODED_REQUEST[1] == 'guest') {
                    $localACTOR = 'guest';
                    $localACTION = 'publiclists';
                } else if ($this->EXPLODED_REQUEST[1] == 'user') {
                    $localACTOR = 'user';
                    $localACTION = 'privatelists';
                } else {
                    $localACTOR = 'none';
                    $localACTION = 'none';
                }
            }
        } else {
            /*
            $localACTOR = 'guest';
            $localACTION = 'publiclists';
            */
            //A l'entrée on redirige vers les listes publiques
            header('Location: /guest/publiclists/1');
        }
        //Si il y a un seul champ dans l'URI, alors les paramètres commencent à partir de l'index 1
        //S'il y a plus de champs, alors les paramètres commencent à l'index 2
        for ($i = 3; $i < $localNombreDeChamps; $i++) {
            $this->PARAMS[] = $this->EXPLODED_REQUEST[$i];
            //echo $this->EXPLODED_REQUEST[$i];
        }
        //echo '</br> ACTION : '.$localACTION.'</br> ACTOR : '.$localACTOR.'</br>'.
        $this->start_dispatch($localACTOR, $localACTION);
    }

    private function start_dispatch($actor, $action)
    {
        global $vues, $ACTIVE_USER;
        $ctrlName = "";
        if (!isset($actor) || !isset($action)) {
            //probleme interne au serveur
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        if ($actor == "none" || $actor == "") {
            //l'acteur demandé est inconnue, alors qu'il y a une action de demandé dessus
            //On affiche donc une 404
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        if ($action == "none" || $action == "") {
            //l'utilisateur demande une action inconnue, on retourne donc une 404
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }

        //VERIFICATION SI L'UTILISATEUR POSSEDE BIEN LE DROIT D'OUVRIR LA PAGE DEMANDEE
        if (isset($ACTIVE_USER) && isset($ACTIVE_USER['role'])) {
            if ($actor == "user" && $ACTIVE_USER['role'] != 'user' && $ACTIVE_USER['role'] != 'admin') {
                //require($vues['goToConnexion']); // ou on peut aussi afficher un forbidden
                header('Location: /guest/signIn');
                return;
            }
        } else {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
            return;
        }
        foreach ($this->listeCtrl as $key => $value) {
            if ($key == $actor) {
                $ctrlName = $value;
                break;
            }
        }
        if ($ctrlName == "") {
            //erreur, on demande un controleur pour un user inexistant
            echo 'youpii';
            ReturnENUM::handleEnum(ReturnENUM::ERROR_404);
            return;
        }
        $className = '\controleur\\' . $ctrlName;
        $CTRL = new $className();
        $CTRL->$action($this->PARAMS);
    }

    /*
     * Permet de vérifier si l acteur est dans la liste d'acteurs autorisé
     * @param $var la varible contenant le supposé acteur
     */
    private function actorVerificator($var): bool
    {
        $res = array_search($var, $this->Acteurs);
        if ($res === false) {
            return false;
        }
        return true;
    }

    private function actionVerificator($role, $action): bool
    {
        foreach ($this->listeActions as $actor => $actions) {
            if ($actor != $role) {
                continue;
            }
            $res = array_search($action, $actions);
            if ($res === false) {
                return false;
            }
            return true;
        }
        return false;
    }

    private function errorPage()
    {
        global $vues;
        require($vues['erreur']);
    }


}
