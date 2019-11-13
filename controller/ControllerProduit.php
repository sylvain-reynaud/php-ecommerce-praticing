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

    public static function showError()
    {
        $controller = "";
        $view = 'error';
        $pagetitle = 'Erreur !';
        require(File::build_path(array("view", "view.php")));
    }

    public static function delete()
    {
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

    public static function create()
    {
        $controller = "produits";
        $view = 'create';
        $pagetitle = "Creation d'un produit";
        require(File::build_path(array("view", "view.php")));
    }

    public static function created(){
        {
            $name = $_FILES['fileToUpload']['name'];
            $pic_path = "images/$name";

            if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                $controller = "produits";
            }
            if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $pic_path)) {
                $name = "default_image.jpg";
            }

            $view = 'list';
            $pagetitle = 'Produit ajouté avec succès !';
            require(File::build_path(array("view", "view.php")));

            $prod = new ModelProduit(0, $_POST['name'], $_POST['desc'], $_POST['price'], $name);

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
