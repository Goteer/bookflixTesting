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

if ( (($_SESSION['role'] == 'suscriptor') and ($cant >= 2)) or (($_SESSION['role'] == 'premium') and ($cant >= 4)) )  { //Si esta debajo del maximo de perfiles...
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Usted tiene demasiados perfiles como para agregar uno nuevo. (MAX: ";
  echo ($_SESSION['role']=='premium'?'4':'2');
  echo ")<br>";
  if ($_SESSION['role'] == 'suscriptor'){
    echo "Puede tener hasta 4 perfiles si se cambia al plan de suscripci&oacute;n premium.<br>";
  }
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";

  echo "</h2></div></div>";
  die();

}


?>



<br>
<div align="center">
<div style="margin-left:10vw;margin-right:10vw;padding-top:1vh;padding-bottom:1vh" id="content-box">

<form id="crearPerfil"  method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/crearPerfil.php"/>
  <input type="hidden" name="nuevo_nombrePerfil" value="'.$next->idPerfil.'"/>

  <h2>Elija un nombre para su nuevo perfil:<br><br>
  <input required type="text" id="nuevo_nombrePerfil" name="nuevo_nombrePerfil" value="<?=(isset($_POST['nuevo_nombrePerfil'])?$_POST['nuevo_nombrePerfil']:'')?>"/></h2><br><br>
  <button type="button" class="botonLeer" onclick="document.getElementById('volverForm').submit();">Volver</button>
  <button class="botonLeer" onclick="this.parentNode.submit();">Crear nuevo perfil</button>
</form>

</div>
</div>
