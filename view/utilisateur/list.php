<div class="row">
    <ul class="collection">
<?php
    global $CSRF_NAME;

    foreach ($tab as $user) {
        echo '
    <li class="collection-item avatar">
        <i class="material-icons circle">account_circle</i>
      <span class="title">'. htmlspecialchars($user->getPseudo()) .'</span>
      <p>'. htmlspecialchars($user->getEmail()) .'<br>
        </p>
        <span class="secondary-content">Admin : <a href="index.php?action=changeAdminMode&controller=ControllerUtilisateur&id='. htmlspecialchars($user->getPseudo()) .'&csrf_token='.$_SESSION[$CSRF_NAME].'" <i class="material-icons">check_circle'. ($user->getIsAdmin() ? '' : '_outline') .'</i></a></span>
    </li>
  ';
    }
?>
    </ul>
</div>


