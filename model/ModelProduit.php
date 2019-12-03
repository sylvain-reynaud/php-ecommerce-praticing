<?php

require_once File::build_path(array("model", "Model.php"));

class ModelProduit extends Model
{

    private $idProduit;
    private $nomProduit;
    private $description;
    private $prix;
    private $imageUrl;
    protected static $objet = "produit";
    protected static $primary='idProduit';

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

            foreach ($data as $key => $value) {
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
}

?>