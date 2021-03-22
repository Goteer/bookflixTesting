<?php

$_SESSION['profileId'] = $_POST['idPerfil'];
$_SESSION['nombrePerfil'] = $_POST['nombrePerfil'];

?>
<form method="POST" id="home" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/home/home.php"/>
</form>

<script>setTimeout(function(){document.forms['home'].submit()},100);</script>
