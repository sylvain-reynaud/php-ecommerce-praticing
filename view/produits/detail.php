<div class="row">
<!--    img  -->
    <div class="col s3">
        <img class="materialboxed" src="images/<?php echo $produit->getId() ?>.jpg">
    </div>
<!--    titre + desc-->
    <div class="col s6">
        <h4><?php echo htmlspecialchars($produit->getName()) ?></h4>
        <p class="flow-text"><?php echo htmlspecialchars($produit->getDesc()) ?></p>
<!--        vendeur-->
        <div class="chip">
            <img src="images/<?php echo htmlspecialchars($produit->getSeller()->getId()) ?>.jpg" alt="Contact the seller">
            <?php echo htmlspecialchars($produit->getSeller()->getName()) ?>
        </div>
    </div>
    <div class="col s3">
        <h5><?php echo htmlspecialchars($produit->getPrice()) ?></h5>
        <button class="btn waves-effect waves-light" name="addToCart">Add to cart
            <i class="material-icons right">add_shopping_cart</i>
        </button>
    </div>
</div>