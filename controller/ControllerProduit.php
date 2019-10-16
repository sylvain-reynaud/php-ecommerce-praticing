<?php

require_once File::build_path(array("model", "ModelProduit.php"));

class ControllerProduit
{

    public static function readAll()
    {
        $tab_prod = ModelProduit::getAllProduits();  //appel au modèle pour gerer la BD
        $controller = 'produits';
        $view = 'list';
        $pagetitle = 'Liste des produits';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

    public static function read()
    {
        $id = $_GET['id'];
        $p = ModelProduit::getProduitById($id);     //appel au modèle pour gerer la BD
        $controller = 'produits';
        if (!$p) {
            $controller = '';
            $view = 'error';
            $pagetitle = 'Erreur !';
            require(File::build_path(array("view", "view.php")));
        } else {
            $view = 'detail';
            $pagetitle = 'Détails';
            require(File::build_path(array("view", "view.php")));
        }
    }

    public static function showError(){
        $controller = "";
        $view = 'error';
        $pagetitle = 'Erreur !';
        require(File::build_path(array("view", "view.php")));
    }

    public static function delete(){
        $id = $_GET['id'];
        $v = ModelProduit::deleteById($id);
        $controller = 'produits';
        if (!$v) {
            $controller = "";
            $view = 'error';
            $pagetitle = 'Erreur !';
            require(File::build_path(array("view", "view.php")));
        }
    }

    public static function create(){
        $controller = "produits";
        $view = 'create';
        $pagetitle = "Creation d'un produit";
        require(File::build_path(array("view", "view.php")));
    }

    public static function created(){
    {
        $prod = new ModelProduit(0,$_GET['name'], $_GET['desc'], $_GET['price']);

        $saveEx = $prod->save();

        if ($saveEx == false) {
            $controller = "";
            $view = 'error';
            $pagetitle = 'Erreur !';
            require(File::build_path(array("view", "view.php")));
        }
    }

    }

}
?>