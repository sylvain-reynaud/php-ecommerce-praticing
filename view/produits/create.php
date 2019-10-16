<form method="get" action="index.php?">
  	<fieldset>
    <legend>Mon formulaire :</legend>
    <p>
      <label for="name">Nom du produit</label> :
      <input type="text" placeholder="Ex : t-shirt" name="name" id="name" required/>
      <br>
      <label for="desc">Description :</label> :
      <input type="text" placeholder="Ex : description du produit" name="desc" id="desc" required/>
<br>
      <label for="price">Prix</label> :
      <input type="text" placeholder="Ex : 18" name="price" id="price" required/>
    </p>
    
    <input type='hidden' name='action' value='created'>

    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>
