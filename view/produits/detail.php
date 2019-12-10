<?php
$url_product = "index.php?action=read&controller=ControllerProduit&id=" . urlencode($p->getId());
$url_delete = "index.php?action=delete&controller=ControllerProduit&id=" . urlencode($p->getId())."&csrf_token=$_SESSION[$CSRF_NAME]";
$url_update = "index.php?action=update&controller=ControllerProduit&id=" . urlencode($p->getId());
$url_addToCart = "index.php?action=addToCart&controller=ControllerProduit&id=".urlencode($p->getId())."&csrf_token=$_SESSION[$CSRF_NAME]";

echo '
<div class="row">
<!--    img  -->
    <div class="col s3">
        <img class="materialboxed responsive-img" width="200" src="images/' . urlencode($p->getImageUrl()) . '">
    </div>
<!--    titre + desc-->
    <div class="col s6">
        <h4>' . htmlspecialchars($p->getName()) . '</h4>
        <p class="flow-text">' . htmlspecialchars($p->getDesc()) . '</p>
<!--        vendeur-->
        <div class="chip">
            <img src="images/2.jpg" alt="Contact the seller">
            ' . htmlspecialchars("Vendeur officiel") . '
        </div>
    </div>
    <div class="col s3">
        <h5>' . htmlspecialchars($p->getPrice()) . ' €</h5>
        <button class="btn waves-effect callToAction" name="addToCart" onclick="window.location.href=\'' . $url_addToCart . '\'">Add to cart
            <i class="material-icons right">add_shopping_cart</i>
        </button>
    </div>
    <div class="col s3">
        <h5>' . $titreLast . '</h5>
        <div class="card">
            <div class="card-image">
                <img src="./images/' . htmlspecialchars($lastProductSeen->getImageUrl()) . '">
                <a class="btn-floating halfway-fab waves-effect waves-light red" href="' . $url_addToCart . '"><i class="material-icons">add_shopping_cart</i></a>
            </div>

            <div class="card-content">
                <span class="card-title">' . htmlspecialchars($lastProductSeen->getName()) . '</span>
                <p>' . $lastProductSeen->getDesc() . '</p>
            </div>
            <div class="card-action">
                <a href="' . $url_product . '">' . htmlspecialchars($lastProductSeen->getPrice()) . '€</a>';
echo '
            </div>
        </div>
    </div>
</div>';

?>

