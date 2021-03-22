<form id="volverForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
</form>

<form id="exitoForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
</form>

<?php


if (!isset($_SESSION['id'])){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: No se recibio un identificador de suscripcion. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}


if (!isset($_POST['idPerfil']) || $_POST['idPerfil'] == ''){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error : No se recibio el identificador del perfil. Intente nuevamente.";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}



if (!$conn->exec("DELETE FROM perfiles WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_POST['idPerfil']."';
    DELETE FROM historial WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_POST['idPerfil']."';
    DELETE FROM librosTerminados WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_POST['idPerfil']."';
    DELETE FROM favoritos WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_POST['idPerfil']."'")){
  //Intento borrar el historial del perfil de la base de datos. No pasa nada si no lo logra porque igual queda inaccesible esa info.
  //$conn->exec("");
  //$conn->exec("");
  //$conn->exec("");
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: No se pudo borrar el perfil por un problema interno. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";

  die();
}else{
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Perfil borrado correctamente.<br>";
  echo "<script>setTimeout(function(){document.forms['exitoForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}


?>
