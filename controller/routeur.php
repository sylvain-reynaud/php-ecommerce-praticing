<?php

require_once File::build_path(array("controller","ControllerVoiture.php"));

if(!isset($_GET['action'])){
    $action = 'readall';
    ControllerProduit::$action();
}


//ControllerVoiture::$action();
?>
