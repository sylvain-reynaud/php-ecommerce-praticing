<?php
$ROOT_FOLDER = __DIR__;
$DS = DIRECTORY_SEPARATOR;
require_once $ROOT_FOLDER.$DS.'lib'. $DS.'File.php';

session_set_cookie_params(0,'/~moulins/');
session_start();

// Création du token csrf
$CSRF_NAME = "csrf_token";
if (!isset($_SESSION[$CSRF_NAME])) {
    $CSRF_TOKEN = uniqid();
    $_SESSION[$CSRF_NAME] = $CSRF_TOKEN;
}

if(!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

if(!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = 'false';
}
if(!isset($_SESSION['login'])) {
    $_SESSION['login'] = '';
}
if(!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = 'false';
}

require File::build_path(array("controller","routeur.php"));

?>