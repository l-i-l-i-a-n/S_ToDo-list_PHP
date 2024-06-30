<?php
// Démarrage de la session
    namespace config;
    use config\Validation;

    class MySession{
        public function __construct() {
            global $ACTIVE_USER;
            session_start();
            // On peut ajouter des variables de sessions :
            //$_SESSION['nom'] = 'Toto';
            
            if(isset($_SESSION['uid']) && isset($_SESSION['role']) && isset($_SESSION['login'])){
                $uid = $_SESSION['uid'];
                $role = $_SESSION['role'];
                $login = $_SESSION['login'];
                if($uid != Validation::validate_Int($uid) || $role != Validation::val_string($role) || $login != Validation::val_string($login)){
                    $ACTIVE_USER['error'] = "id/login/role incorrect";
                }
                else{
                    $ACTIVE_USER['uid'] = $uid;
                    $ACTIVE_USER['login'] = $login;
                    $ACTIVE_USER['role'] = $role;

                }
            }
            else {
                $ACTIVE_USER['uid'] = 0;
                $ACTIVE_USER['login'] = 'public';
                $ACTIVE_USER['role'] = 'guest';
            }
        }
    }
?>