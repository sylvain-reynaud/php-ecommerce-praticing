<div class="row">
<!--    img  -->
    <div class="col s3">
        <img class="materialboxed" width="300" src="images/<?php echo $p->getId() ?>.jpg">
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
            <?php echo htmlspecialchars("Bob") ?>
        </div>
    </div>
    <div class="col s3">
        <h5><?php echo htmlspecialchars($p->getPrice()) ?></h5>
        <button class="btn waves-effect waves-light" name="addToCart">Add to cart
            <i class="material-icons right">add_shopping_cart</i>
        </button>
    </div>
</div>