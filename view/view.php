<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <!-- materializecss -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="styles/view.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<header>
    <nav>
        <div class="nav-wrapper">
            <a href="index.php" class="brand-logo">Logo</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php">Nos produits</a></li>
                <li><a href="index.php?action=readCart&controller=ControllerProduit">Panier
                        : <?php echo ControllerProduit::countProductsInCart(); ?> produits</a></li>

                <?php

                if($_SESSION['admin'] == 'true'){
                    echo <<<OEF
                    <li><a href="index.php?action=create&controller=ControllerProduit">Ajouter un produit</a></li>
                    <li><a href="index.php?action=readAll&controller=ControllerUtilisateur">Liste des utilisateurs</a></li>
OEF;
                }

                if ($_SESSION['logged'] == 'false') {
                    echo <<<EOF
                    <li><a href="index.php?action=create&controller=ControllerUtilisateur">Créer un compte</a></li>
                    <li><a href="index.php?action=connect&controller=ControllerUtilisateur">Se connecter</a></li>
EOF;
                } else {
                    echo <<<OEF
                    <li><a href="index.php?action=account&controller=ControllerUtilisateur">Mon compte</a></li>
                    <li><a href="index.php?action=disconnect&controller=ControllerUtilisateur">Deconnexion</a></li>
OEF;
                }


                ?>
            </ul>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        <?php
        // Si $controleur='voiture' et $view='list',
        // alors $filepath="/chemin_du_site/view/voiture/list.php"
        $filepath = File::build_path(array("view", $controller, "$view.php"));
        require $filepath;
        ?>
    </div>
</main>
<footer class="page-footer">
    <div class="footer-copyright">
        <div class="container">
            © 2019 Copyright Text
            <a class="grey-text text-lighten-4 right" href="https://github.com/sylvain-reynaud/projet-php/">Repo
                Github</a>
        </div>
    </div>
</footer>

<!--    Js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.materialboxed');
        var instances = M.Materialbox.init(elems);
        var elem = document.querySelector('.collapsible');
        var instance = M.Collapsible.init(elem, {
            accordion: false
        });
    });
</script>
</body>
</html>