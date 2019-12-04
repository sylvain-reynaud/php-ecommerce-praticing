<div class="row">
<?php
    global $CSRF_NAME;
    foreach ($tab_prod as $p) {
        $url_product = "index.php?action=read&controller=ControllerProduit&id=" . htmlspecialchars($p->getId());
        $url_delete = "index.php?action=delete&controller=ControllerProduit&id=" . htmlspecialchars($p->getId())."&csrf_token=$_SESSION[$CSRF_NAME]";
        $url_update = "index.php?action=update&controller=ControllerProduit&id=" . htmlspecialchars($p->getId());
        $url_addToCart = "index.php?action=addToCart&controller=ControllerProduit&id=".htmlspecialchars($p->getId())."&csrf_token=$_SESSION[$CSRF_NAME]";
        echo '
    <div class="col s9 m3">
    <div class="card">
            <div class="card-image">
                <img src="./images/' . htmlspecialchars($p->getImageUrl()) . '">
                <a class="btn-floating halfway-fab waves-effect waves-light red" href="'.$url_addToCart.'"><i class="material-icons">add_shopping_cart</i></a>
            </div>
            
            <div class="card-content">
                <span class="card-title">' . htmlspecialchars($p->getName()) . '</span>
                <p>' . $p->getDesc() . '</p>
            </div>
            <div class="card-action">
            <a href="' . $url_product . '">' . htmlspecialchars($p->getPrice()) . '€</a>
            ';
            if($_SESSION['admin']=='true'){
                echo '
                <a href="' . $url_update . '">Modifier</a>
                <a href="' . $url_delete . '">Supprimer</a>';
            }
            

            echo '
</div>
</div>
        </div>' . "\n";
    }
    ?>
</div>
