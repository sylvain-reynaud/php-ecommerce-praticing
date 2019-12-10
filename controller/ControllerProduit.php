<?php

require_once File::build_path(array("model", "ModelProduit.php"));


class ControllerProduit
{
    /**
     * Vérifie le token CSRF
     * @return bool
     */
    public static function csrfCheck()
    {
        global $CSRF_NAME;
//        var_dump($_GET);
//        var_dump($_POST);
        // GET
        if (isset($_SESSION[$CSRF_NAME]) AND isset($_GET[$CSRF_NAME]) AND
            !empty($_SESSION[$CSRF_NAME]) AND !empty($_GET[$CSRF_NAME])) {
            return $_SESSION[$CSRF_NAME] == $_GET[$CSRF_NAME];
        }
        // POST
        elseif (isset($_SESSION[$CSRF_NAME]) AND isset($_POST[$CSRF_NAME]) AND
            !empty($_SESSION[$CSRF_NAME]) AND !empty($_POST[$CSRF_NAME])){
            return $_SESSION[$CSRF_NAME] == $_POST[$CSRF_NAME];
        } else { return false;}
    }

    /**
     * Affiche la page Panier
     */
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

    /**
     * Compte le nombre de produits dans le panier
     * @return int
     */
    public static function countProductsInCart()
    {
        $sum = 0;
        $tab_prod = $_SESSION['panier'];

        foreach ($tab_prod as $data) {
            $sum += $data["quantity"];
        }
        return $sum;
    }

    /**
     * Ajoute le produit passé par get dans le panier
     */
    public static function addToCart()
    {
        if (self::csrfCheck()) {
            if (isset($_GET["id"]) && ModelProduit::select($_GET["id"])) {
                if (array_key_exists($_GET["id"], $_SESSION['panier'])) {
                    $_SESSION['panier'][$_GET["id"]]["quantity"] += 1;
                } else {
                    $_SESSION['panier'] += array($_GET["id"] => array("quantity" => 1));
                }
            }
            self::readAll();
        } else {
            // pas de token csrf
            echo "Erreur de vérification !";
        }
    }

    /**
     * Enleve le produit passé par get du panier
     */
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

    /**
     * Affiche la liste de tous les produits du site
     */
    public static function readAll()
    {
        $tab_prod = ModelProduit::selectAll();  //appel au modèle pour gerer la BD
        $controller = 'produits';
        $view = 'list';
        $pagetitle = 'Liste des produits';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

    /**
     * Renvoie l'id d'un produit aléatoire, utile pour afficher un autre produit qui pourrait intéresser le client
     *  sur la page d'un produit
     * @param $idQuOnNeVeutPas  id d'un produit exclu de la selection
     * @return int
     */
    public static function randomId($idQuOnNeVeutPas)
    {
        $tab_prod = ModelProduit::selectAll();
        do {
            $r = $tab_prod[array_rand($tab_prod)];
        } while ($r->getId() == $idQuOnNeVeutPas);
        return $r->getId();
    }

    /**
     * Affiche la page détaillée d'un produit
     */
    public static function read()
    {
        $id = $_GET['id'];
        $p = ModelProduit::select($id);     //appel au modèle pour gerer la BD
        $controller = 'produits';
        if (!$p) {
            self::showError("Produit inconnu");
        } else {
            $view = 'detail';
            $pagetitle = 'Détails';
            if (isset($_COOKIE["lastProductSeen"]) and
                $_COOKIE["lastProductSeen"] != $id and
                ModelProduit::select($_COOKIE["lastProductSeen"])) {
                $titreLast = "Dernier produit vu :";
                $lastProductSeen = ModelProduit::select($_COOKIE["lastProductSeen"]);
            } else {
                // Affiche un autre produit aléatoire
                $titreLast = "Ce produit pourrait vous plaire :";
                $lastProductSeen = ModelProduit::select(ControllerProduit::randomId($id));
            }
            setcookie("lastProductSeen", $id, time() + 3600, "/~moulins/"); // 1h
            require(File::build_path(array("view", "view.php")));
        }
    }

    /**
     * Afficher une page d'erreur
     */
    public static function showError($error)
    {
        $controller = "";
        $view = 'error';
        $pagetitle = 'Erreur !';
        require(File::build_path(array("view", "view.php")));
    }

    /**
     * Supprime un produit passé en get
     */
    public static function delete()
    {

        if (self::csrfCheck() && $_SESSION['admin'] == 'true') {
            $id = $_GET['id'];
            $v = ModelProduit::delete($id);
            $controller = 'produits';
            if ($v) {
                self::showError("Produit invalide");
            } else {
                self::readAll();
            }
        } else {
            self::showError("Vous n'avez pas l'autorisation de faire ça, sorry bruh");
        }
    }

    /**
     * Affiche la page form pour creer un produit
     */
    public static function create()
    {
        if ($_SESSION['admin'] == 'true') {
            $controller = "produits";
            $view = 'create';
            $pagetitle = "Creation d'un produit";
            $type = 'created';

            $id = '';
            $name = '';
            $desc = '';
            $prix = '';

            require(File::build_path(array("view", "view.php")));
        } else {
            self::showError("Vous n'avez pas l'autorisation de faire ça, sorry bruh");
        }
    }

    /**
     * Affiche la page form pour modifier un produit
     */
    public static function update()
    {
        if ($_SESSION['admin'] == 'true' and isset($_GET['id'])) {

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
        } else {
            self::showError("Vous n'avez pas l'autorisation de faire ça, sorry bruh");
        }
    }

    /**
     * Modifie un produit
     */
    public static function updated()
    {
        if (self::csrfCheck() and $_SESSION['admin'] == 'true') {

            $values = array(
                "idProduit" => $_POST['idProduit'],
                "nomProduit" => $_POST['nomProduit'],
                "description" => $_POST['description'],
                "prix" => $_POST['prix']
            );

            if(!empty($_FILES['fileToUpload']) && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])){
                $name = $_FILES['fileToUpload']['name'];
                $path = array("images", "$name");
                $pic_path = File::build_path($path);
                if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $pic_path)) {
                    echo "La copie a échoué";
                }else{
                $values['imageUrl'] = $name;
                }
            }

            

            ModelProduit::update($values);

            self::readAll();
        } else {
            self::showError("Vous n'avez pas l'autorisation de faire ça, sorry bruh!");
        }


    }

    /**
     * Creer un nouveau produit
     */
    public static function created()
    {
        {
            if (/*self::csrfCheck() && */ $_SESSION['admin'] == 'true') {
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
//                var_dump($prod);

                $saveEx = ModelProduit::save($val);

                if ($saveEx == false) {
                    self::showError("Produit invalide");
                }
                self::readAll();
            } else {
                self::showError("Acces interdit");
            }
        }
    }
}
