<?php

require_once File::build_path(array("controller", "ControllerProduit.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));

if (isset($_GET['action']) && isset($_GET['controller'])) {
    $action = $_GET['action'];
    $controller = $_GET['controller'];
    $availableActions = get_class_methods($controller);
    if (!is_null($availableActions) and in_array($action, $availableActions)) {
        $controller::$action();
    } else {
        ControllerProduit::showError("Bien essayé");
    }
} else {
    ControllerProduit::readAll();
}
?>
