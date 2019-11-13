<?php
$ROOT_FOLDER = __DIR__;
$DS = DIRECTORY_SEPARATOR;
require_once $ROOT_FOLDER.$DS.'lib'. $DS.'File.php';

session_start();
if(!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

require File::build_path(array("controller","routeur.php"));

?>