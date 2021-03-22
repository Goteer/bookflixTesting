<form id="volverForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
</form>

<?php
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.perfil.php");
$perfiles = $conn->query("SELECT COUNT(*) FROM perfiles WHERE idUsuario = '".$_SESSION['id']."'");

if (!$cant = $perfiles->fetchColumn()){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error al recuperar perfiles del usuario de la base de datos. Por favor intente mas tarde.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";

  echo "</h2></div></div>";
  die();
}

if ( $cant <= 1 )  { //Si esta en el minimo de perfiles...
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "No puede borrar todos sus perfiles, debe tener al menos uno.";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();

}

if (!isset($_POST['idPerfil']) || $_POST['idPerfil'] == ''){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error interno: No se recibio el identificador del perfil. Volviendo a perfiles...";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}

?>



<br>
<div align="center">
<div style="margin-left:10vw;margin-right:10vw;padding-top:1vh;padding-bottom:1vh" id="content-box">

<form id="borrarPerfil"  method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/borrarPerfil.php"/>
  <input type="hidden" name="idPerfil" value="<?=$_POST['idPerfil']?>"/>

  <h2>&iquest;Est&aacute; seguro de borrar el perfil "<?=$_POST['nombrePerfil']?>"?<br>
  <button type="button" class="botonLeer" onclick="document.getElementById('volverForm').submit();">Volver</button>
  <button class="botonLeer" onclick="this.parentNode.submit();">Borrar el perfil</button>
</form>

</div>
</div>
