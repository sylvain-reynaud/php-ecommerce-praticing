<form method="post" action="index.php?action=<?php echo $type ?>&controller=ControllerProduit" enctype="multipart/form-data">
  	<fieldset>
    <legend> Ajout d'un produit : </legend>
    <p>
      <label for="nomProduit">Nom du produit :</label>
            <input type="hidden" name="token_csrf" id="token_csrf" value="<?php global $CSRF_NAME; echo $_SESSION[$CSRF_NAME]; ?>" />
            <input type="text" value="<?php echo $name ?>" placeholder="Ex : t-shirt" name="nomProduit" id="nomProduit" required />
            <br>
            <label for="description">Description :</label>
            <input type="text" value="<?php echo $desc ?>" placeholder="Ex : description du produit" name="description" id="description" required />
            <br>
            <label for="prix">Prix</label>
            <input type="text" value="<?php echo $prix ?>" placeholder="Ex : 18" name="prix" id="prix" required />
            <br>

    
    <label for="fileToUpload">Photo du produit</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
    </p>
    
    <input type='hidden' name='action' value='<?php echo $type ?>'>
    <input type='hidden' name='idProduit' value='<?php echo $id ?>'>
    
    <input type='hidden' name='imageUrl' value=''>

    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>
