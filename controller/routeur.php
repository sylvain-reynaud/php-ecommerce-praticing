<?php

require_once File::build_path(array("controller","ControllerProduit.php"));

if(isset($_GET['action'])){
    $action = $_GET['action'];
    $availableActions = get_class_methods("ControllerProduit");
    if (in_array($action, $availableActions)) {
        ControllerProduit::$action();
    }
    else {
        ControllerProduit::showError();
    }
}
else {
    ControllerProduit::readAll();
}
?>
