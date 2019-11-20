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
    
            require(File::build_path(array("view", "view.php")));
        }

        public static function connect(){
            $controller="utilisateur";
            $view="connect";
            $pagetitle = "Page de connexion :";
            
            require(File::build_path(array("view", "view.php")));
        }

        public static function connected(){
            $controller="produits";
            $view="list";
            $pagetitle = "Connecté!";

            $pseudo = $_POST['pseudo'];
            $password = Security::chiffrer($_POST['password']);

            if(ModelUtilisateur::checkPassword($pseudo, $password)){
                ControllerProduit::readAll();
            }else{
                self::connect();
            }
        }

        public static function created(){
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
            }

        }

    }
?>