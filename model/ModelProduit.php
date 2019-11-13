<?php

require_once File::build_path(array("model", "Model.php"));

class ModelProduit
{

    private $idProduit;
    private $nomProduit;
    private $description;
    private $prix;
    private $imageUrl;

    /*
    public function __construct($id = NULL, $nom = NULL, $desc = NULL, $prix = NULL, $image = NULL)
    {
        if (!is_null($id) && !is_null($nom) && !is_null($desc) && !is_null($prix)) {

            $this->idProduit = $id;
            $this->nomProduit = $nom;
            $this->description = $desc;
            $this->prix = $prix;
            $this->imageUrl = $image;
        }
    }
    */

    public function __construct($data = NULL)
    {
        if (!is_null($data) && !empty($data)) {

            foreach ($data as $key=> $value){
                $this->$key = $value;
            }
        }
    }

    public function getId()
    {
        return $this->idProduit;
    }

    public function getName()
    {
        return $this->nomProduit;
    }

    public function getDesc()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->prix;
    }

    /**
     * @return null
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }




    public static function getAllProduits()
    {

        $sql = "SELECT * FROM produits";
        $rep = Model::$pdo->query($sql);

        $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProduit');
        $tab_prod = $rep->fetchAll();

        return $tab_prod;
    }

    public static function getProduitById($id)
    {
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

    public static function update($data){
        $sql = "UPDATE produits SET nomProduit=:nom, description= :desc, prix= :prix WHERE idproduit= :id";
        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "id" => $data['id'],
            "nom" => $data['name'],
            "desc" => $data['desc'],
            "prix" => $data['price']
        );
        // On donne les valeurs et on exécute la requête   
        $req_prep->execute($values);
    }

    public static function deleteById($id)
    {
        $sql = "DELETE FROM `produits` WHERE idproduit = :id;";
        try {
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "id" => $id
            );

            $req_prep->execute($values);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }
        }
        return true;
    }

    public function save()
    {
        $sql = "INSERT INTO `produits` (`nomProduit`, `description`, `prix`, `imageUrl`) VALUES (:nom, :descrip, :price, :imageUrl);";
        try {
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "nom" => $this->nomProduit,
                "descrip" => $this->description,
                "price" => $this->prix,
                "imageUrl" => $this->imageUrl
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