<form method="post" action="index.php?action=updated" enctype="multipart/form-data">
    <?php
    require_once File::build_path(array("model", "ModelProduit.php"));
    $id = $_GET['id'];
    $pro = ModelProduit::getProduitById($id);
    ?>
    <fieldset>
        <legend> Modification d'un produit : </legend>
        <p>
            <label for="name">Nom du produit :</label>
            <input type="text" value="<?php echo $pro->getName() ?>" placeholder="Ex : t-shirt" name="name" id="name" required />
            <br>
            <label for="desc">Description :</label>
            <input type="text" value="<?php echo $pro->getDesc() ?>" placeholder="Ex : description du produit" name="desc" id="desc" required />
            <br>
            <label for="price">Prix</label>
            <input type="text" value="<?php echo $pro->getPrice() ?>" placeholder="Ex : 18" name="price" id="price" required />
            <br>

            <!--
    <label for="fileToUpload">Photo du produit</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    </p> -->

            <input type='hidden' name='action' value='created'>
            <input type='hidden' name='id' value='<?php echo $pro->getId() ?>'>

            <p>
                <input type="submit" value="Envoyer" />
            </p>
    </fieldset>
</form>