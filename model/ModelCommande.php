<?php

require_once File::build_path(array("model", "Model.php"));

class ModelCommande
{

    private $idCommande;
    private $idUser;
    private $produits; // comme le panier

    public function __construct($data = NULL)
    {
        if (!is_null($data) && !empty($data)) {

            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function getId()
    {
        return $this->idCommande;
    }

    public function getUserPseudo()
    {
        return $this->idUser;
    }

    public function getProduits()
    {
        return $this->produits;
    }

    public static function getAllOrdersOfUser($userId)
    {
        $sql = "SELECT * FROM commandes WHERE idUser=:userId";
        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "userId" => $userId,
        );
        // On donne les valeurs et on exécute la requête
        $req_prep->execute($values);

        // On récupère les résultats comme précédemment
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCommande');
        $tab = $req_prep->fetchAll();
        // Attention, si il n'y a pas de résultats, on renvoie false
        if (empty($tab))
            return false;
        return $tab;
    }

    public static function getProductsFromOrder($id)
    {
        $sql = "SELECT * FROM produitsCommandes WHERE idCommande=:id";

        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "id" => $id,
        );
        // On donne les valeurs et on exécute la requête
        $req_prep->execute($values);

        // On récupère les résultats comme précédemment
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelProduit');
        $tab_prod = $req_prep->fetchAll();
        // Attention, si il n'y a pas de résultats, on renvoie false
        if (empty($tab_prod))
            return false;
        return $tab_prod;

    }

    public static function getCommandeById($id)
    {
        $sql = "SELECT * from commandes WHERE id=:id";
        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "id" => $id,
        );
        // On donne les valeurs et on exécute la requête
        $req_prep->execute($values);

        // On récupère les résultats comme précédemment
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCommande');
        $tab_prod = $req_prep->fetchAll();
        // Attention, si il n'y a pas de résultats, on renvoie false
        if (empty($tab_prod))
            return false;
        return $tab_prod[0];
    }


    public function save()
    {
        $sql = "INSERT INTO `commandes` (`idUser`) VALUES (:idUser);";
        try {
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "idUser" => $this->getUserPseudo()
            );

            $req_prep->execute($values);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }
        }

        $lastId = Model::$pdo->lastInsertId();

        foreach ($this->produits as $productId => $productArr) {
            $sql = "INSERT INTO `produitsCommandes` (`idCommande`, `idProduit`, `quantite`) VALUES (:idCommande, :idProduit, :quantite);";
            try {
                $req_prep = Model::$pdo->prepare($sql);
                $values = array(
                    "idCommande" => intval($lastId),
                    "idProduit" => $productId,
                    "quantite" => $productArr["quantity"],
                );

                $req_prep->execute($values);
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    return false;
                }
            }
        }

        return true;
    }
}

?>