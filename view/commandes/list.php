<div class="row">
    <ul class="collapsible">
<?php
if (!$tab) {
    echo "<p>Vous n'avez pas encore passé de commande.</p>";
} else {
    foreach ($tab as $c) {
        echo '<li>
                <div class="collapsible-header"><i class="material-icons">filter_drama</i> Commande n°' . $c->getId() . '</div>
                <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
              </li>';
    }
    }
    ?>
    </ul>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.collapsible');
            var instances = M.Collapsible.init(elems, options);
        });
    </script>
</div>
