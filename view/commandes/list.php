<div class="row">
    <ul class="collapsible">
<?php
if (!$tab) {
    echo "<p>Vous n'avez pas encore passé de commande.</p>";
} else {
    foreach ($tab as $order) {
        $produits = $order->getProduits()[0];
        echo '<li>
                <div class="collapsible-header"><i class="material-icons">filter_drama</i> Commande n°' . $order->getId() . '</div>
                <div class="collapsible-body">
                    <ul>';
        foreach ($produits as $item) {
            $p = $item["object"];
            $quantity = $item["quantity"];
            echo '<li>
                        <ul>
                            <li>'.$quantity. 'x ' .$p->getName().'<li>
                            <li>'.$p->getPrice()*$quantity.' €<li>
                        </ul><br>
                    </li>';
        }

        echo '</ul></div></li>';
    }
}
?>
    </ul>
</div>


