<?php

    require_once File::build_path(array("model","ModelUtilisateur.php"));

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

        public static function created(){
            $val = array(
                "pseudo" => $_POST['pseudo'],
                "email" => $_POST['email'],
                "mdp" => $_POST['password'],
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