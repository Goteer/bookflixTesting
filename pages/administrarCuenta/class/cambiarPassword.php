<form method="POST" id="volver" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>
<br>
<div align="center">
<div class="content-box" style="width:80vw;">

  <form method="POST" id="error" action="../navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/administrarCuenta/cambiarPassword.php"/>
  </form>
  <div align="center">
  <div id="content-box">
<h2>
<?php

include_once "../../resources/framework/class/class.user.php";

$suscriptores = new UserDB();
$suscriptores->setFiltro("id = '".$_SESSION['id']."'");
$suscriptores->setOtros("LIMIT 1");

$suscriptores->fetchRecordSet($conn);
$suscriptor = $suscriptores->getNextRecord();
$valoresUser = $suscriptor->getValues();



if  ( (isset($_POST['oldPassword']) and $_POST['oldPassword'] != '') and (isset($_POST['newPassword']) and $_POST['newPassword'] != '') ) {

  if ($_POST['oldPassword'] == $valoresUser['uPassword']){

    $query = "UPDATE users SET uPassword = " . $conn->quote($_POST['newPassword']) . " WHERE id = " . $_SESSION['id'];

    if ($conn->query($query)){
      echo "Cambios realizados con exito.";
      echo "<script>setTimeout(function(){document.forms['volver'].submit()},2000);</script>";
    }else{
      echo "Hubo un error al realizar los cambios. Intente nuevamente mas tarde.";
      echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
    }

  }else{
    echo "La contrase&ntilde;a actual que ingres&oacute; no coincide con la registrada. Acceso denegado.";
    echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
  }

}else{
  echo "Falta ingresar datos. Debes ingresar tanto la contrase&ntilde;a actual como la nueva.";
  echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
}


?>
</h2>
</div>
</div>
