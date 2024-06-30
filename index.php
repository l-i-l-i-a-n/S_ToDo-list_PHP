<?php
use controleur\FrontControleur;
use config\MySession;

require_once(__DIR__.'/config/config.php');

//autoloader conforme norme PSR-0
require_once(__DIR__.'/config/SplClassLoader.php');
$myLibLoader = new SplClassLoader('controleur', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('config', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('modeles', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('DAL', './modeles');
$myLibLoader->register();

$sess = new MySession();
$con = new FrontControleur();