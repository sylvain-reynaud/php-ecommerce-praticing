<form method="POST" action="index.php?action=<?php echo $type ?>&controller=ControllerUtilisateur" enctype="multipart/form-data">
  	<fieldset>
    <legend> Ajout d'un utilisateur : </legend>
    <p>
    <label for="pseudo">Pseudo :</label>
            <input type="text" value="<?php echo $pseudo ?>" placeholder="Ex : TotoDu34" name="pseudo" id="pseudo" required />
            <br>
            <label for="email">Email :</label>
            <input type="email" value="<?php echo $email ?>" placeholder="Ex : totodu34@gmail.com" name="email" id="email" required />
            <br>
            <label for="password">Password</label>
            <input type="password" value="<?php echo $mdp ?>" placeholder="Ex : *****" name="password" id="password" required />
            <br>
            
            <label for="verifpassword">Retapez votre mdp</label>
            <input type="password" value="" placeholder="Ex : " name="verifpassword" id="verifpassword" required />
            <br>
            <p style="color: red"><?php echo $erreur ?></p>

    <input type='hidden' name='action' value='<?php echo $type ?>'>
    <input type='hidden' name='isAdmin' value='false'>

    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>
