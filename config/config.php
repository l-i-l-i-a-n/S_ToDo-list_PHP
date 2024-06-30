<?php
$rep=__DIR__.'/../';
// Connexion à la base de données : 
$base="phptodolist";
$login="root"; // Pourquoi vide ?
$mdp="";
$dsn="mysql:host=localhost;dbname=phptodolist";

// DEMANDER SI C'EST BIEN DE FAIRE CA COMME CA :
$GLOBALS = array(
    'base' => $base,
    'username' => $login,
    'password' => $mdp,
    'dsn' => $dsn
);

/** VIEWS **/
$vues['MainTodo']='vues/MainTodo.php';
$vues['todo']='vues/todo.php';
$vues['TodoList']='vues/TodoList.php';
$vues['header']='vues/Header.php';
$vues['footer']='vues/footer.php';

/** ACCOUNT RELATED VIEWS **/
$vues['inscription']='vues/Inscription.php';
$vues['signIn']='vues/signIn.php';
$vues['accountPage']='vues/accountPage.php';
$vues['deleteConfirmation']='vues/deleteConfirmation.php';

/** ADMIN VIEWS **/
$vues['Admin']='vues/AdminView.php';
$vues['TodolistLog']='vues/TodolistLog.php';
$vues['TodoLog']='vues/TodoLog.php';
$vues['UserLog']='vues/UserLog.php';

/** ERROR VIEWS **/
$vues['400error']='vues/errors/400error.php';
$vues['404error']='vues/errors/404error.php';
$vues['403error']='vues/errors/403error.php';
$vues['500error']='vues/errors/500error.php';
$vues['errorPopUp']='vues/ErrorPopUp.php';

// l'utilisateur actif :
$ACTIVE_USER['login'] = "";
$ACTIVE_USER['role'] = "guest";
$ACTIVE_USER['error'] = "";

$DATA_VUE['true'] =  "true";
$DATA_VUE['page'] = "public";

$INIT_PARAMS['pseudoMinLen'] = 3;
$INIT_PARAMS['pseudoMaxLen'] = 95; // 100 en BD
$INIT_PARAMS['passwordMinLen'] = 5;
$INIT_PARAMS['passwordMaxLen'] = 95; // 100 en BD
$INIT_PARAMS['todoMinLen'] = 1; //300 en BD
$INIT_PARAMS['todoMaxLen'] = 300; //300 en BD
$INIT_PARAMS['titleMaxLen'] = 300; //300 en BD
$INIT_PARAMS['titleMinLen'] = 1;