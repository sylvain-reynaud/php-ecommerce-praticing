<?php

require_once File::build_path(array("model", "ModelProduit.php"));


class ControllerProduit
{

    private static function csrfCheck() {
        global $CSRF_NAME;
        if (isset($_SESSION[$CSRF_NAME]) AND isset($_GET[$CSRF_NAME]) AND
            !empty($_SESSION[$CSRF_NAME]) AND !empty($_GET[$CSRF_NAME])) {
            return $_SESSION[$CSRF_NAME] == $_GET[$CSRF_NAME];
        }
    }

    public static function readCart()
    {
        $tab_prod = $_SESSION['panier'];

        foreach ($tab_prod as $id => $quantity) {
            $tab_prod[$id] += array("obj" => ModelProduit::select($id));
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
        if (self::csrfCheck()){
                if (isset($_GET["id"]) && ModelProduit::select($_GET["id"])) {
                    if (array_key_exists($_GET["id"], $_SESSION['panier'])) {
                        $_SESSION['panier'][$_GET["id"]]["quantity"] += 1;
                    } else {
                        $_SESSION['panier'] += array($_GET["id"] => array("quantity" => 1));
                    }
                }
                self::readAll();
        }
        else {
            // pas de token csrf
            echo "Erreur de vérification !";
        }
    }

    public static function removeFromCart()
    {
        if (self::csrfCheck()) {
            if (isset($_GET["id"])) {
                if (array_key_exists($_GET["id"], $_SESSION['panier'])) {
                    unset($_SESSION['panier'][$_GET["id"]]);
                }
            }
            self::readCart();
        }
    }

    public static function readAll()
    {
        $tab_prod = ModelProduit::selectAll();  //appel au modèle pour gerer la BD
        $controller = 'produits';
        $view = 'list';
        $pagetitle = 'Liste des produits';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

    public static function randomId($idQuOnNeVeutPas)
    {
        $tab_prod = ModelProduit::selectAll();
        do {
            $r = $tab_prod[array_rand($tab_prod)];
        } while($r->getId() == $idQuOnNeVeutPas);
        return $r->getId();
    }

    public static function read()
    {
        $id = $_GET['id'];
        $p = ModelProduit::select($id);     //appel au modèle pour gerer la BD
        $controller = 'produits';
        if (!$p) {
            $controller = '';
            $view = 'error';
            $pagetitle = 'Erreur !';
            require(File::build_path(array("view", "view.php")));
        } else {
            $view = 'detail';
            $pagetitle = 'Détails';
            if(isset($_COOKIE["lastProductSeen"]) and
                $_COOKIE["lastProductSeen"] != $id and
                ModelProduit::select($_COOKIE["lastProductSeen"])) {
                $titreLast = "Dernier produit vu :";
                $lastProductSeen = ModelProduit::select($_COOKIE["lastProductSeen"]);
            }
            else {
                // Affiche un autre produit aléatoire
                $titreLast = "Ce produit pourrait vous plaire :";
                $lastProductSeen = ModelProduit::select(ControllerProduit::randomId($id));
            }
            setcookie("lastProductSeen", $id, time()+3600); // 1h
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

        if (self::csrfCheck() && $_SESSION['admin'] == 'true') {
            $id = $_GET['id'];
            $v = ModelProduit::delete($id);
            $controller = 'produits';
            if ($v) {
                $controller = "";
                $view = 'error';
                $pagetitle = 'Erreur !';
                require(File::build_path(array("view", "view.php")));
            }else{
                self::readAll();
            }
        }else{
            self::showError();
        }
    }

    public static function create()
    {
        if($_SESSION['admin']=='true'){
            $controller = "produits";
            $view = 'create';
            $pagetitle = "Creation d'un produit";
            $type= 'created';

            $id = '';
            $name = '';
            $desc = '';
            $prix = '';

            require(File::build_path(array("view", "view.php")));
        }else{
            self::showError();
        }
    }

    public static function update()
    {


        if ($_SESSION['admin'] == 'true'){

            $controller = "produits";
            $view = 'create';
            $pagetitle = "Modification d'un produit";
            $type = 'updated';

            $pro = ModelProduit::select($_GET['id']);


            $id = $pro->getId();
            $name = $pro->getName();
            $desc = $pro->getDesc();
            $prix = $pro->getPrice();
            require(File::build_path(array("view", "view.php")));
        }else{
            self::showError();
        }
    }

    public static function updated()
    {
        if($_SESSION['admin']=='true'){

            $values = array(
                "idProduit" => $_POST['idProduit'],
                "nomProduit" => $_POST['nomProduit'],
                "description" => $_POST['description'],
                "prix" => $_POST['prix']
            );

            ModelProduit::update($values);
            self::readAll();
        }else{
            self::showError();
        }


    }

    public static function created(){
        {
            if (/*self::csrfCheck() && */$_SESSION['admin']=='true') {
                $name = $_FILES['fileToUpload']['name'];
                $pic_path = "images/$name";

                if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                    $controller = "produits";
                }
                if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $pic_path)) {
                    $name = "default_image.jpg";
                }


                $val = array(
                    "nomProduit" => $_POST['nomProduit'],
                    "description" => $_POST['description'],
                    "prix" => $_POST['prix'],
                    "imageUrl" => $name
                );

                $prod = new ModelProduit($val);
                var_dump($prod);

                $saveEx = $prod::save($val);

                if ($saveEx == false) {
                    $controller = "";
                    $view = 'error';
                    $pagetitle = 'Erreur !';
                    require(File::build_path(array("view", "view.php")));
                }
                self::readAll(); 
            }else{
                self::showError();
            }
        }
    }
}
