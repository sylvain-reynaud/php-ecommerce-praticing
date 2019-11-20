<ul class="collection">
<?php
    global $CSRF_NAME;
    foreach ($tab_prod as $id => $data) {
        $p = $data["obj"];
        $quantity = $data["quantity"];

        $url_product = "index.php?action=read&controller=ControllerProduit&id=" . $p->getId();
        $url_removeOfCart = "index.php?action=removeFromCart&controller=ControllerProduit&id=" . $p->getId()."&csrf_token=$_SESSION[$CSRF_NAME]";
        $url_addToCart = "index.php?action=addToCart&controller=ControllerProduit&id=".$p->getId();
        echo '
            <div class="col s9 m3">
            <li class="collection-item avatar">
                    <img src="./images/' . $p->getImageUrl() . '" class="circle">
                    <span class="title">'.$p->getName().'</span>
                      <p>Quantité : '.$quantity.'<br>
                         Prix : '.$p->getPrice().'
                      </p>
                      <a href="'.$url_removeOfCart.'" class="secondary-content"><i class="material-icons">delete</i></a>
        </div>
        </li>
        ' . "\n";
    }
    ?>
</ul>
