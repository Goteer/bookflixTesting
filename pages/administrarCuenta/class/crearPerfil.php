<form id="volverForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/agregarPerfil.php"/>
  <input type="hidden" name="nuevo_nombrePerfil" value="<?=$_POST['nuevo_nombrePerfil']?>"/>
</form>

<form id="exitoForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
</form>

<?php
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.perfil.php");
$perfil = new PerfilDB();
$perfiles = new PerfilDB();
if (!isset($_SESSION['id'])){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: No se recibio un identificador de suscripcion. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}


if (!isset($_POST['nuevo_nombrePerfil'])){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: No se recibi&oacute; un nombre de perfil. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}

$perfiles->setFiltro("nombre = '".$_POST['nuevo_nombrePerfil']."' AND idUsuario = '".$_SESSION['id']."'");
$perfiles->fetchRecordSet($conn);
if ($perfiles->getNextRecord()){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: Ya posee un perfil con ese nombre.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}

$perfil->current->setValues($_POST['nuevo_nombrePerfil'],$_SESSION['id']);

if (!$perfil->insert($conn)){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error: No se pudo crear el perfil por un problema interno. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}else{
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Perfil creado correctamente.<br>";
  echo "<script>setTimeout(function(){document.forms['exitoForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}


?>
