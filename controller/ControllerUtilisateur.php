<?php

require_once File::build_path(array("model", "ModelUtilisateur.php"));
require_once File::build_path(array("model", "ModelCommande.php"));
require_once File::build_path(array("controller", "ControllerProduit.php"));
require_once File::build_path(array("controller", "ControllerCommande.php"));

require_once File::build_path(array("lib", "Security.php"));

class ControllerUtilisateur
{

    public static function disconnect()
    {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 1);

        $CSRF_TOKEN = uniqid();
        $CSRF_NAME = "csrf_token";
        $CSRF_TOKEN = uniqid();
        $_SESSION[$CSRF_NAME] = $CSRF_TOKEN;
        $_SESSION['panier'] = array();
        $_SESSION['logged'] = 'false';
        $_SESSION['login'] = '';
        $_SESSION['admin'] = 'false';

        ControllerProduit::readAll();
    }

    public static function validate()
    {
        $login = $_GET['pseudo'];
        $nonce = $_GET['nonce'];
        $user = ModelUtilisateur::select($login);

        if (ModelUtilisateur::select($login) && $nonce == $user->getNonce()) {
            $user->setNonceNull();
            ControllerUtilisateur::connect();

        } else {
            echo("Mauvais lien de confirmation");
        }
    }

    public static function connect()
    {
        $controller = "utilisateur";
        $view = "connect";
        $pagetitle = "Page de connexion :";

        require(File::build_path(array("view", "view.php")));
    }

    public static function connected()
    {
        $controller = "produits";
        $view = "list";
        $pagetitle = "Connecté!";

        $pseudo = $_POST['pseudo'];
        $password = Security::chiffrer($_POST['password']);


        if (ModelUtilisateur::checkPassword($pseudo, $password)) {
            $user = ModelUtilisateur::select($pseudo);
            if ($user->getNonce() == 'NULL') {
                $_SESSION['logged'] = 'true';
                $_SESSION['login'] = $pseudo;
                $admin = $user->getIsAdmin();
                if ($admin) {
                    $_SESSION['admin'] = 'true';
                }
                ControllerProduit::readAll();
            } else {
                self::connect();
            }
        } else {
            self::connect();
        }
    }

    public static function created()
    {

        if (($_POST['password']) != ($_POST['verifpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur = "Entrez des mots de passes identiques";
            self::create();
        } else {


            $val = array(
                "pseudo" => $_POST['pseudo'],
                "email" => $_POST['email'],
                "mdp" => Security::chiffrer($_POST['password']),
                "isAdmin" => 0,
                "nonce" => Security::generateRandomHex()
            );

            $u = new ModelUtilisateur($val);
            var_dump($val);
            var_dump($u);

            $saveEx = $u::save($val);
            if ($saveEx == false) {
                $controller = "";
                $view = 'error';
                $pagetitle = 'Erreur !';
                require(File::build_path(array("view", "view.php")));
            } else {
                /*
                $mail = "Veuillez valider votre adresse mail à cette adresse : http://localhost/projet-php/index.php?action=validate&controller=ControllerUtilisateur&pseudo=" . $u->getPseudo() . "&nonce=" . $u->getNonce;

                mail($u->getEmail(), $mail); */

                //ControllerProduit::readAll();
            }

        }
    }

    public static function create()
    {
        $controller = "utilisateur";
        $view = 'create';
        $pagetitle = "Creation d'un utilisateur";
        $type = 'created';

        $pseudo = '';
        $email = '';
        $password = '';
        $mdp = '';
        if (!isset($erreur)) {
            $erreur = '';
        }

        require(File::build_path(array("view", "view.php")));
    }

    public static function deliveryInfo()
    {
        if (json_decode($_SESSION['logged'])) { // 'false' est une str -> utilisation de json_decode
            $controller = "utilisateur";
            $view = "deliveryInfo";
            $pagetitle = "Détails de la livraison";
            $type = "updateDeliveryInfo";

            $user = ModelUtilisateur::select($_SESSION['login']);

            $name = $user->getName();
            $rue = $user->getRue();
            $postalCode = $user->getPostalCode();
            $erreur = '';

            require(File::build_path(array("view", "view.php")));
        } else {
            ControllerUtilisateur::connect();
        }
    }

    public static function updateDeliveryInfo()
    {
        ModelUtilisateur::saveDeliveryInfo($_POST);
        if (!empty($_SESSION["panier"])) {
            $commande = new ModelCommande(array("idUser" => $_SESSION["login"],
                "produits" => $_SESSION["panier"]));
            $commande->save(array("idUser" => $_SESSION["login"]));
            $_SESSION['panier'] = array();
        }
        // TODO : redirection vers historique commande (readall) + msg "commande confirmée"
        ControllerCommande::readAllOfUser($_SESSION["login"]);
    }

    public static function readAllOrders()
    {
        $tab_prod = ModelUtilisateur::selectAll();  //appel au modèle pour gerer la BD
        $controller = 'utilisateur';
        $view = 'list';
        $pagetitle = 'Liste des commandes passées';
        require(File::build_path(array("view", "view.php")));  //"redirige" vers la vue
    }

}

?>
