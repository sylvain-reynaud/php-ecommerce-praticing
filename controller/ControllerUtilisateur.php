<?php

    require_once File::build_path(array("model","ModelUtilisateur.php"));
    require_once File::build_path(array("controller","ControllerProduit.php"));

    require_once File::build_path(array("lib","Security.php"));

    class ControllerUtilisateur{

        public static function create(){
            $controller = "utilisateur";
            $view = 'create';
            $pagetitle = "Creation d'un utilisateur";
            $type= 'created';    
    
            $pseudo = '';
            $email = '';
            $password = '';
            $mdp = '';
            if(!isset($erreur)){
                $erreur='';
            }
    
            require(File::build_path(array("view", "view.php")));
        }

        public static function connect(){
            $controller="utilisateur";
            $view="connect";
            $pagetitle = "Page de connexion :";
            
            require(File::build_path(array("view", "view.php")));
        }

        public static function disconnect(){
            session_unset();
            session_destroy();
            setcookie(session_name(),'', time()-1);

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

        public static function connected(){
            $controller="produits";
            $view="list";
            $pagetitle = "Connecté!";

            $pseudo = $_POST['pseudo'];
            $password = Security::chiffrer($_POST['password']);

            if(ModelUtilisateur::checkPassword($pseudo, $password)){
                $_SESSION['logged'] = 'true';
                $_SESSION['login'] = $pseudo;

                $user = ModelUtilisateur::getUserByPseudo($pseudo);
                $admin = $user->getIsAdmin();
                if($admin){
                    $_SESSION['admin'] = 'true';
                }
                ControllerProduit::readAll();
            }else{
                self::connect();
            }
        }

        public static function created(){

            if(($_POST['password'])!= ($_POST['verifpassword'])){
                $erreur="Entrez des mots de passes identiques";
                self::create();
            }else{


            $val = array(
                "pseudo" => $_POST['pseudo'],
                "email" => $_POST['email'],
                "mdp" => Security::chiffrer($_POST['password']),
                "isAdmin" => $_POST['isAdmin']
            );

            $u = new ModelUtilisateur($val);

            $saveEx = $u->save();
            if ($saveEx == false) {
                $controller = "";
                $view = 'error';
                $pagetitle = 'Erreur !';
                require(File::build_path(array("view", "view.php")));
            }else{

                ControllerProduit::readAll();
            }

        }
        }
    }
?>