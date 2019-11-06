<div class="row">
<!--    img  -->
    <div class="col s3">
        <img class="materialboxed responsive-img" width="200" src="images/<?php echo $p->getImageUrl()?>">
    </div>
<!--    titre + desc-->
    <div class="col s6">
        <h4><?php echo htmlspecialchars($p->getName()) ?></h4>
        <p class="flow-text"><?php echo htmlspecialchars($p->getDesc()) ?></p>
<!--        vendeur-->
        <div class="chip">
<!--            <img src="images/--><?php //echo htmlspecialchars($p->getSeller()->getId()) ?><!--.jpg" alt="Contact the seller">-->
<!--            --><?php //echo htmlspecialchars($p->getSeller()->getName()) ?>
            <img src="images/2.jpg" alt="Contact the seller">
            <?php echo htmlspecialchars("Vendeur officiel") ?>
        </div>
    </div>
    <div class="col s3">
        <h5><?php echo htmlspecialchars($p->getPrice()) ?> €</h5>
        <button class="btn waves-effect callToAction" name="addToCart">Add to cart
            <i class="material-icons right">add_shopping_cart</i>
        </button>
    </div>
</div>