<?php

require_once File::build_path(array("model", "ModelProduit.php"));

class ControllerProduit {

    public static function readAll()
    {
        $tab_prod = ModelProduit::getAllProduits();  //appel au modèle pour gerer la BD
        $controller = 'produits';
        $view = 'list';
        $pagetitle = 'Liste des produits';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

    public static function read(){
        
    }

    

}
?>