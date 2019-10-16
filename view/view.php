<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <!-- materializecss -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <header>
        <ul>
            <li><a href="index.php?action=readAll">Voir toutes les voitures</a></li>
            <li><a href="index.php?action=readAll&controller=utilisateur">Utilisateurs</a></li>
            <li><a href="index.php?action=readAll&controller=trajet">Trajets</a></li>
        </ul>
    </header>
    <?php
    // Si $controleur='voiture' et $view='list',
    // alors $filepath="/chemin_du_site/view/voiture/list.php"
    $filepath = File::build_path(array("view", $controller, "$view.php"));
    require $filepath;
    ?>
    <p style="border: 1px solid black;text-align:right;padding-right:1em;">
        Site de covoiturage de Simon Moulin
    </p>
</body>

</html>