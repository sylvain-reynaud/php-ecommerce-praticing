<ul class="collection">
<?php
    global $CSRF_NAME;
    if (!empty($tab_prod)) {
        foreach ($tab_prod as $id => $data) {
            $p = $data["obj"];
            $quantity = $data["quantity"];

            $url_product = "index.php?action=read&controller=ControllerProduit&id=" . $p->getId();
            $url_removeOfCart = "index.php?action=removeFromCart&controller=ControllerProduit&id=" . $p->getId()."&csrf_token=$_SESSION[$CSRF_NAME]";
            $url_addToCart = "index.php?action=addToCart&controller=ControllerProduit&id=".$p->getId();
            echo '
            <li class="collection-item avatar">
            
            <div class="col s9 m3">
                    <img src="./images/' . $p->getImageUrl() . '" alt="imageProduit" class="circle">
                    <span class="title">'.$p->getName().'</span>
                      <p>Quantité : '.$quantity.'<br>
                         Prix : '.$p->getPrice().'
                      </p>
                      <a href="'.$url_removeOfCart.'" class="secondary-content"><i class="material-icons">delete</i></a>
        </div>
        </li>
        ' . "\n";
        }
        echo '</ul><button class="btn waves-effect waves-light" type="submit" onclick="document.location.href=\'index.php?action=deliveryInfo&controller=ControllerUtilisateur\'">Commander
    <i class="material-icons right">send</i>
</button>';
    } else {
        echo '
            <div class="col s9 m3">
                <p>Aucun produit dans le panier</p>
            </div></ul>';
    }
    ?>