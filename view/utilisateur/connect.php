<form method="POST" action="index.php?action=connected&controller=ControllerUtilisateur" enctype="multipart/form-data">
  	<fieldset>
    <legend> Connection : </legend>
    <p>
    <label for="pseudo">Pseudo :</label>
            <input type="text" placeholder="Ex : TotoDu34" name="pseudo" id="pseudo" required />
            <br>
            <label for="password">Password</label>
            <input type="password" placeholder="Ex : *****" name="password" id="password" required />
            <br>

    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>
