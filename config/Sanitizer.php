<?php

namespace config;

class Sanitizer{
    
    public static function sanitize_String(string &$st) {
        if(!isset($st) || $st=="") return false;
        return filter_var($st,FILTER_SANITIZE_STRING);
    }
    
    public static function sanitize_Email(string &$email){
        if(!isset($email) || $email=="") return false;
        return filter_var($email,FILTER_SANITIZE_EMAIL);
    }
    
    public static function sanitize_Html($input, $encoding = 'UTF-8')
    {   
        return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
    }
    
    //COMMENT IMPLEMENTER LA VALIDATION D'UN FORMULAIRE 
    static function sanitize_form(string &$email, string &$motDePassOne, string &$motDePassTwo, &$dVueEreur) {
        
        if ($email != Sanitize::sanitize_Email($email)) {
            $dVueEreur[] = "email incorrect !";
            $email="";
        }
        if ($nom != filter_var($nom, FILTER_SANITIZE_STRING))
        {
            $dVueEreur[] = "testative d'injection de code (attaque sécurité)";
            $nom="";

        }

        if (!isset($age)||$age==""||!filter_var($age, FILTER_VALIDATE_INT)) {
            $dVueEreur[] = "pas d'age ";
            $age=0;
        }

    }
}
