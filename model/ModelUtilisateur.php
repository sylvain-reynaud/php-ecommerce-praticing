<?php

    require_once File::build_path(array("model","Model.php"));

    class ModelUtilisateur{
        private $pseudo;
        private $email;
        private $mdp;
        private $isAdmin;
        private $nonce;

        public function __construct($data = NULL)
        {
            if (!is_null($data) && !empty($data)) {
                foreach ($data as $key => $value) {
                    $this->$key = $value;
                }
            }
        }

        public function getPseudo(){
            return $this->pseudo;
        }

        public function getNonce(){
            return $this->nonce;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getMdp(){
            return $this->mdp;
        }
        public function getIsAdmin(){
            return $this->isAdmin;
        }
        public function setNonceNull(){
            $this->nonce = 'NULL';
            $sql = "UPDATE user SET nonce='NULL' where pseudo=:pseudo";

            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "pseudo" => $this->pseudo
            );

            $req_prep->execute($values);

        }


        
        public static function getUserByPseudo($pseudo)
        {
            $sql = "SELECT * from user WHERE pseudo=:pseudonyme";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "pseudonyme" => $pseudo,
                //nomdutag => valeur, ...
            );
            // On donne les valeurs et on exécute la requête
            $req_prep->execute($values);

            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
            $tab_prod = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab_prod))
                return false;
            return $tab_prod[0];
        }

        public static function checkPassword($pseudo, $mdpChiffrer){
            $sql = "SELECT * FROM user WHERE pseudo=:pseudo AND mdp=:pass";

            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "pseudo" => $pseudo,
                "pass" => $mdpChiffrer
            );

            $req_prep->execute($values);

            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateur");
            $tab = $req_prep->fetchAll();

            var_dump($tab);
            if(empty($tab)){
                return false;
            }else{
                return true;
            }


        }


        public function save()
        {
            $sql = "INSERT INTO `user` (`pseudo`, `email`, `mdp`, `isAdmin`,`nonce`) VALUES (:pseudo, :email, :mdp, :isAdmin,:nonce);";
            try {
                $req_prep = Model::$pdo->prepare($sql);
                $values = array(
                    "pseudo" => $this->pseudo,
                    "email" => $this->email,
                    "mdp" => $this->mdp,
                    "isAdmin" => $this->isAdmin,
                    "nonce" => $this->nonce
                );
    
                $req_prep->execute($values);
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    return false;
                }
            }
            return true;
        }
    }
?>