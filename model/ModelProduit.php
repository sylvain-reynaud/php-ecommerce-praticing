<?php

require_once File::build_path(array("model", "Model.php"));

class ModelProduit
{

    private $idProduit;
    private $nomProduit;
    private $description;
    private $prix;

    public function __construct($id = NULL, $nom = NULL, $desc = NULL, $prix = NULL)
    {
        if (!is_null($id) && !is_null($nom) && !is_null($desc) && !is_null($prix)) {

            $this->idProduit = $id;
            $this->nomProduit = $nom;
            $this->description = $desc;
            $this->prix = $prix;
        }
    }

    public function getIdProduit(){
        return $this->idProduit;
    }

    public static function getAllProduits()
    {

        $sql = "SELECT * FROM produits";
        $rep = Model::$pdo->query($sql);

        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProduit');
        $tab_prod = $rep->fetchAll();

        return $tab_prod;
    }

    public static function getProduitById($id) {
        $sql = "SELECT * from produits WHERE idProduit=:nom_tag";
        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
    
        $values = array(
            "nom_tag" => $id,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête   
        $req_prep->execute($values);
    
        // On récupère les résultats comme précédemment
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelProduit');
        $tab_prod = $req_prep->fetchAll();
        // Attention, si il n'y a pas de résultats, on renvoie false
        if (empty($tab_prod))
            return false;
        return $tab_prod[0];
      }
    
}

?>