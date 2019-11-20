<?php
$ROOT_FOLDER = __DIR__;
$DS = DIRECTORY_SEPARATOR;
require_once $ROOT_FOLDER.$DS.'lib'. $DS.'File.php';

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

require File::build_path(array("controller","routeur.php"));

?>