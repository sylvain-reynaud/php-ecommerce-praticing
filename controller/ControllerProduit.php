<?php

require_once File::build_path(array("model", "ModelProduit.php"));

class ControllerProduit
{

    public static function readCart()
    {
        $tab_prod = $_SESSION['panier'];

        foreach ($tab_prod as $id => $quantity) {
            $tab_prod[$id] += array("obj" => ModelProduit::getProduitById($id));
        }
        $controller = 'produits';
        $view = 'cart';
        $pagetitle = 'Mon panier';
        require(File::build_path(array("view", "view.php")));
    }

    public static function countProductsInCart() {
        $sum = 0;
        $tab_prod = $_SESSION['panier'];

        foreach ($tab_prod as $data) {
            $sum += $data["quantity"];
        }
        return $sum;
    }

    public static function addToCart()
    {
        if(isset($_GET["id"]) && ModelProduit::getProduitById($_GET["id"])) {
            if(array_key_exists($_GET["id"], $_SESSION['panier'])) {
                $_SESSION['panier'][$_GET["id"]]["quantity"] += 1;
            } else {
                $_SESSION['panier'] += array($_GET["id"] => array("quantity" => 1));
            }
        }
        self::readAll();
    }

    public static function removeFromCart()
    {
        if(isset($_GET["id"])) {
            if (array_key_exists($_GET["id"], $_SESSION['panier'])) {
                unset($_SESSION['panier'][$_GET["id"]]);
            }
        }
        self::readCart();
    }

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
        self::readAll();
    }

    public static function create()
    {
        $controller = "produits";
        $view = 'create';
        $pagetitle = "Creation d'un produit";
        $type= 'created';    

        $id = '';
        $name = '';
        $desc = '';
        $prix = '';

        require(File::build_path(array("view", "view.php")));
    }

    public static function update()
    {
        $controller = "produits";
        $view = 'create';
        $pagetitle = "Modification d'un produit";
        $type = 'updated';

        $pro = ModelProduit::getProduitById($_GET['id']);
    

        $id = $pro->getId();
        $name = $pro->getName();
        $desc = $pro->getDesc();
        $prix = $pro->getPrice();
        require(File::build_path(array("view", "view.php")));
    }

    public static function updated()
    {
        ModelProduit::update($_POST);
        self::readAll();


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

            
            $val = array(
                "idProduit" => 0,
                "nomProduit" => $_POST['name'],
                "description" => $_POST['desc'],
                "prix" => $_POST['price'],
                "imageUrl" => $name
            );

            $prod = new ModelProduit($val);

            $saveEx = $prod->save();

            if ($saveEx == false) {
                $controller = "";
                $view = 'error';
                $pagetitle = 'Erreur !';
                require(File::build_path(array("view", "view.php")));
            }
            self::readAll();
        }
    }
}
