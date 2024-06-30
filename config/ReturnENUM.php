<?php

namespace config;

abstract class ReturnENUM
{
    //Basics :
    const OK = 'ok';
    const NOT_OK = 'notOk';
    const ERROR_500 = '500error';
    const ERROR_400 = '400error';
    const ERROR_403 = '403error';
    const ERROR_404 = '404error';

    //Les GoTo :
    const GOTO_MAINPAGE = 'goToMainPage';
    const GOTO_CONNEXION = 'goToConnexion';

    //Password :
    const WRONG_PASSWORD = 'wrongPassword';
    const PASSWORD_LENGTH = 'passwordLength';


    //Pseudo : 
    const WRONG_PSEUDO = 'wrongPseudo';
    const PSEUDO_LENGTH = 'pseudoLength';
    const PSEUDO_ALREADY_EXIST = 'pseudoAlreadyExist';

    //Todo : 
    const TODO_LENGTH = 'todoLength';

    //TodoLists : 
    const TODOLIST_LENGTH = 'todoListLength';

    //
    const WRONG_NB_LISTS = -1;

    //
    const FALSE = false;

    //
    const EMPTY_ARRAY = [];

    //
    const NULL = null;

    public static function handleEnum(string $val)
    {
        global $vues;
        if (!isset($val)) {
            require($vues['500error']);
            return;
        }
        switch ($val) {
            case ReturnENUM::ERROR_400:
                require($vues['400error']);
                exit();
                break;
            case ReturnENUM::NOT_OK:
            case ReturnENUM::WRONG_NB_LISTS:
            case ReturnENUM::FALSE:
            case ReturnENUM::EMPTY_ARRAY:
            case ReturnENUM::ERROR_500:
            case ReturnENUM::NULL:
                require($vues['500error']);
                exit();
                break;
            case ReturnENUM::ERROR_403:
                require($vues['403error']);
                exit();
                break;
            case ReturnENUM::ERROR_404:
                require($vues['404error']);
                exit();
                break;
            default:
                break;
        }
    }

}

