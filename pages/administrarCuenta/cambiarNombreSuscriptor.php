<?php
include_once "../../resources/framework/class/class.user.php";

$suscriptores = new UserDB();
$suscriptores->setFiltro("id = '".$_SESSION['id']."'");
$suscriptores->setOtros("LIMIT 1");

$suscriptores->fetchRecordSet($conn);
$suscriptor = $suscriptores->getNextRecord();
$valoresUser = $suscriptor->getValues();
?>
<style>

#header {
  background-image: linear-gradient(to bottom,#111, #333);
  height:3vh;
}

#cuerpo{
  margin-left: 5vw;
  margin-right: 5vw;
  background-color: #333;
}
#suscriptor{
  margin-left: 3vw;
  margin-right: 3vw;
}

#footer{
  background-image: linear-gradient(to top,#111, #333);
  height:3vh;
}
#suscriptor button {
  background-color: #555555;
  color: white;
  padding: 4px 7px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#suscriptor button:hover {
  background-color: #444444;
}

#suscriptor img {
  width:32px;
  height:auto;
}
</style>
<br>
<div id="cuerpo">
<div id="header">&nbsp;</div>




<div id="suscriptor">
  <form method="POST" id="volver" action="../navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
    <a onClick="this.parentNode.submit();"><button type="button"> Volver a cuenta </button></a>
  </form>
<br>

  <form method="POST" id="enviarNombre" action="../navigation/nav.php">

  <label>Nombre:</label> <input type="text" name="nombre" pattern="[a-zA-Z\x20]+" maxlength="32" title="Solo se aceptan letras y espacios" value="<?= (isset($_POST['nombre']))?$_POST['nombre']:$valoresUser['nombre'] ?>"/><br>
  <label>Apellido:</label> <input type="text" name="apellido" pattern="[a-zA-Z\x20]+" maxlength="32" title="Solo se aceptan letras y espacios" value="<?= (isset($_POST['apellido']))?$_POST['apellido']:$valoresUser['apellido'] ?>"/><br>


  <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/cambiarNombre.php"/>
  <input type="submit" value="Cambiar nombre/apellido">
  </form>
</div>





<div id="footer">&nbsp;</div>
</div>