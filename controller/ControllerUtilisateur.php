<?php

require_once File::build_path(array("model", "ModelUtilisateur.php"));
require_once File::build_path(array("model", "ModelCommande.php"));
require_once File::build_path(array("controller", "ControllerProduit.php"));
require_once File::build_path(array("controller", "ControllerCommande.php"));

require_once File::build_path(array("lib", "Security.php"));

class ControllerUtilisateur
{

    /**
     * Deconnecte l'user
     */
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

    /**
     * Confirme l'email d'un user
     */
    public static function validate()
    {
        $login = $_GET['pseudo'];
        $nonce = $_GET['nonce'];
        $user = ModelUtilisateur::select($login);

        if (ModelUtilisateur::select($login) && $nonce == $user->getNonce()) {
            $user->setNonceNull();
            ControllerUtilisateur::connect();

        } else {
            ControllerProduit::showError("Mauvais lien de confirmation");
        }
    }

    /**
     * Afficher page de connexion user
     */
    public static function connect()
    {
        $controller = "utilisateur";
        $view = "connect";
        $pagetitle = "Page de connexion :";

        require(File::build_path(array("view", "view.php")));
    }

    /**
     * Connecte l'user
     */
    public static function connected()
    {
        $pseudo = $_POST['pseudo'];
        $password = Security::chiffrer($_POST['password']);

        if (ModelUtilisateur::checkPassword($pseudo, $password)) {
            $user = ModelUtilisateur::select($pseudo);
            if ($user->getNonce() == 'NULL') {
                $_SESSION['logged'] = 'true';
                $_SESSION['login'] = $user->getPseudo();
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

    /**
     * Crée un nouvel user
     */
    public static function created()
    {

        if (($_POST['password']) != ($_POST['verifpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur = "Entrez des mots de passe identiques";
            $controller = "utilisateur";
            $view = 'create';
            $pagetitle = "Création d'un utilisateur";
            $type = 'created';

            $u = ModelUtilisateur::select($_SESSION['login']);

            $pseudo = $_POST['pseudo'];
            $email = $_POST['email'];
            $password = '';

            require(File::build_path(array("view", "view.php")));
        } else {

            $val = array(
                "pseudo" => $_POST['pseudo'],
                "email" => $_POST['email'],
                "mdp" => Security::chiffrer($_POST['password']),
                "isAdmin" => 0,
                "nonce" => Security::generateRandomHex()
            );

            $u = new ModelUtilisateur($val);

            $saveEx = $u::save($val);
            if ($saveEx == false) {
                ControllerProduit::showError("Utilisateur invalide");
            } else {
                $mail = "Veuillez valider votre adresse mail à cette adresse : http://webinfo.iutmontp.univ-montp2.fr/~moulins/eCommerce/index.php?action=validate&controller=ControllerUtilisateur&pseudo=" . $u->getPseudo() . "&nonce=" . $u->getNonce();
                mail($u->getEmail(), "Activation de votre compte sur test", $mail);
                ControllerProduit::readAll();
            }

        }
    }

    /**
     * Affiche la page form d'inscription
     */
    public static function create()
    {
        if (empty($_SESSION['login'])) {
            $controller = "utilisateur";
            $view = 'create';
            $pagetitle = "Creation d'un utilisateur";
            $type = 'created';

            $pseudo = '';
            $email = '';
            $password = '';
            $mdp = '';

            require(File::build_path(array("view", "view.php")));
        } else {
            ControllerProduit::showError("Action impossible");
        }
    }

    /**
     * Affiche la page form pour update un user
     */
    public static function update()
    {
        $controller = "utilisateur";
        $view = 'create';
        $pagetitle = "Creation d'un utilisateur";
        $type = 'updated';

        if (!empty($_SESSION['login'])) {
            $u = ModelUtilisateur::select($_SESSION['login']);


            $pseudo = $u->getPseudo();
            $email = $u->getEmail();
            $password = '';
            $mdp = '';
            $erreur = '';

            require(File::build_path(array("view", "view.php")));
        } else {
            ControllerProduit::showError("Vous n'etes pas connecté");
        }

    }

    /**
     * Met à jour l'user
     */
    public static function updated()
    {
        if ($_SESSION['login'] == $_POST['pseudo']) {
            if (($_POST['password']) != ($_POST['verifpassword']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $erreur = "Entrez des mots de passes identiques";
                $controller = "utilisateur";
                $view = 'create';
                $pagetitle = "Creation d'un utilisateur";
                $type = 'updated';

                $u = ModelUtilisateur::select($_SESSION['login']);


                $pseudo = $_POST['pseudo'];
                $email = $_POST['email'];
                $password = '';
                $mdp = '';

                require(File::build_path(array("view", "view.php")));

            } else {

                // ModelUtilisateur::select()


                $val = array(
                    "pseudo" => $_POST['pseudo'],
                    "email" => $_POST['email'],
                    "mdp" => Security::chiffrer($_POST['password']),
                );

                ModelUtilisateur::update($val);


                ControllerProduit::readAll();
            }
        }
        else {
            ControllerProduit::showError("T'essaies de faire quoi là ?");
        }
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
            $data = array("idUser" => $_SESSION["login"],
                "produits" => $_SESSION["panier"]);
            ModelCommande::save($data);
            $_SESSION['panier'] = array();
        }
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
