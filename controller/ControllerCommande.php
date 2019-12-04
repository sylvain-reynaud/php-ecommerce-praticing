<?php

require_once File::build_path(array("model", "ModelCommande.php"));


class ControllerCommande
{
    // TODO lister toutes les commandes
    public static function readAllOfUser($userId) {
        $tab = ModelCommande::getAllOrdersOfUser($userId);  //appel au modèle pour gerer la BD
        $controller = 'commandes';
        $view = 'list';
        $pagetitle = 'Liste des commandes';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

    // TODO lister les produits d'une commande (id)
    public static function readById($id) {

    }

    // TODO crée une commande
    public static function create() {

    }
}
