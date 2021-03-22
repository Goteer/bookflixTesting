<form method="POST" id="verPerfiles" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
</form>

<?php
$_SESSION['nombrePerfil'] = null;
$_SESSION['profileId'] = null;


?>

<script>setTimeout(function(){document.forms['verPerfiles'].submit()},100);</script>
