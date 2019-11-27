<form method="POST" action="index.php?action=<?php echo $type ?>&controller=ControllerUtilisateur" enctype="multipart/form-data">
    <fieldset>
        <legend> Information sur la livraison : </legend>
        <p>
            <label for="name">Prénom Nom :</label>
            <input type="text" value="<?php echo $name ?>" placeholder="Ex : Olivier Minne" name="name" id="name" required />
            <br>
            <label for="rue">Rue :</label>
            <input type="text" value="<?php echo $rue ?>" placeholder="Ex : 7 rue de pommiers" name="rue" id="rue" required />
            <br>
            <label for="postalCode">Code postal</label>
            <input type="text" value="<?php echo $postalCode ?>" placeholder="Ex : 34000" name="postalCode" id="postalCode" required />
            <br>
        <p style="color: red"><?php echo $erreur ?></p>

        <input type='hidden' name='action' value='<?php echo $type ?>'>

        <p>
            <input type="submit" value="Confirmer mes informations" />
        </p>
    </fieldset>
</form>
