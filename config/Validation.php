<?php

namespace config;
use config\Sanitizer;
class Validation {

    static function validate_action($action) : bool
    {
        if (!isset($action)) {
            return false;
            //on pourrait aussi utiliser
            //$action = $_GET['action'] ?? 'no';
            // This is equivalent to:
            //$action =  if (isset($_GET['action'])) $action=$_GET['action']  else $action='no';
        }
        //clear HTML 
        $actionXSS = Sanitizer::sanitize_Html($action);
        
        if($action != filter_var($actionXSS,FILTER_SANITIZE_STRING)){
            return false;
        }
        return true;
    }
    
    static function validate_uri($url) : bool
    {
        
        if(!isset($url) || $url == "") return false;
        
        if($url != filter_var($url,FILTER_SANITIZE_URL)){
            return false;
        }
        return true;
    }
    
    
    
    public static function validate_Email(string $email) : bool{
        if(!isset($email) || $email==""){
            return false;
        }
        $emailXSS = Sanitizer::sanitize_Html($email);
        return filter_var($emailXSS,FILTER_VALIDATE_EMAIL);
    }
    
    public static function validate_Int(int $nb) : bool{
        if(!isset($nb)){
            return false;
            
        }
        //Clear HTML
        $nbXSS = Sanitizer::sanitize_Html($nb);
        return filter_var($nbXSS,FILTER_VALIDATE_INT);
    }
    
    /**
     * Permet de valider une string.
     * @param type $value
     * @return bool
     */
    static function val_string($value) : bool{
        //A FAIREEEEEEEEEE
        if($value != filter_var($value,FILTER_SANITIZE_STRING)){
            $dVueEreur[] = "testative d'injection de code (attaque sécurisée)";
            $description = "";
            return false;
        }else{
            return true;
        }
    }
    
    /**
     * Permet de valider la taille d'une todo
     * @global type $INIT_PARAMS
     * @param string $descript
     * @return bool
     */
    static function val_todo_size(string $descript):bool
    {
        global $INIT_PARAMS;
        if(!isset($descript)){
            return false;
        }
        return Validation::check_btw_size(strlen($descript), $INIT_PARAMS['todoMinLen'], $INIT_PARAMS['todoMaxLen']);
    }
    
    /**
     * Permet de valider la taille du titre d'une liste.
     * @global \config\type $INIT_PARAMS
     * @param string $title
     * @return bool
     */
    static function val_todoList_size(string $title):bool
    {
        global $INIT_PARAMS;
        if(!isset($title)){
            return false;
        }
        return Validation::check_btw_size(strlen($title), $INIT_PARAMS['titleMinLen'], $INIT_PARAMS['titleMaxLen']);
    }
    
    /**
     * Permet de valider la taille du pseudo
     * @global \config\type $INIT_PARAMS
     * @param string $pseudo
     * @return bool
     */
    static function val_pseudo_size(string $pseudo):bool
    {
        global $INIT_PARAMS;
        if(!isset($pseudo)){
            return false;
        }
        return Validation::check_btw_size(strlen($pseudo), $INIT_PARAMS['pseudoMinLen'], $INIT_PARAMS['pseudoMaxLen']);
    }
    
    /**
     * Permet de valider la taille du mot de passe.
     * @global \config\type $INIT_PARAMS
     * @param string $password
     * @return bool
     */
    static function val_password_size(string $password):bool
    {
        global $INIT_PARAMS;
        if(!isset($password)){
            return false;
        }
        return Validation::check_btw_size(strlen($password), $INIT_PARAMS['passwordMinLen'], $INIT_PARAMS['passwordMaxLen']);
    }
    
    /**
     * Permet de vérifier si une valeur est entre les deux bornes
     * @param int $val
     * @param int $min
     * @param int $max
     * @return bool
     */
    static function check_btw_size(int $val, int $min, int $max):bool
    {
        if(!isset($val) || !isset($min) || !isset($max)){
            return false;
        }
        if($val >= $min && $val <= $max){
            return true;
        }
        return false;
        
    }
    
    

}
?>