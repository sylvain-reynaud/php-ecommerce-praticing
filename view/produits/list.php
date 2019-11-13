<div class="row">
    <?php
    foreach ($tab_prod as $p) {
        $url_product = "index.php?action=read&id=" . $p->getId();
        $url_delete = "index.php?action=delete&id=" . $p->getId();
        $url_update = "index.php?action=update&id=" . $p->getId();
        echo '
    <div class="col s9 m3">
    <div class="card">
            <div class="card-image">
                <img src="./images/' . $p->getImageUrl() . '">
                <a class="btn-floating halfway-fab waves-effect waves-light red" href="' . $url_product . '"><i class="material-icons">add_shopping_cart</i></a>
            </div>
            
            <div class="card-content">
                <span class="card-title">' . $p->getName() . '</span>
                <p>' . $p->getDesc() . '</p>
            </div>
            <div class="card-action">
            <a href="' . $url_product . '">' . $p->getPrice() . '€</a>
            
            
            <a href="' . $url_update . '">Modifier</a>
            <a href="' . $url_delete . '">Supprimer</a>
</div>
</div>
        </div>' . "\n";
    }
    ?>
</div>