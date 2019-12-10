<div class="row">
    <ul class="collapsible">
<?php

    foreach ($tab as $user) {
        $produits = $user->getProduits()[0];
        echo '<li>
                <div class="collapsible-header"><i class="material-icons">filter_drama</i> ' . $user->getId() . '</div>
                <div class="collapsible-body">
                    <ul>';
        foreach ($produits as $item) {
            $p = $item["object"];
            $quantity = $item["quantity"];
            echo '<li>
                        <ul>
                            <li>'.$quantity. 'x ' .$p->getName().'<ul>
                            <li>'.$p->getPrice()*$quantity.' €<ul>
                        </ul>
                    </li><br>';
        }

        echo '</ul></div></li>';
    }
?>
    </ul>
</div>


