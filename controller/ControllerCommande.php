<?php

require_once File::build_path(array("model", "ModelCommande.php"));


class ControllerCommande
{
    /**
     * Afficher la page de toutes les commandes d'un user
     * @param $userId   id de l'utilisateur qui veut afficher ses commandes
     */
    public static function readAllOfUser($userId)
    {
        $tab = ModelCommande::getAllOrdersOfUser($userId);  //appel au modèle pour gerer la BD
        $controller = 'commandes';
        $view = 'list';
        $pagetitle = 'Liste des commandes';
        require(File::build_path(array("view", "view.php")));
    }
}
