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
#suscriptor button, #suscriptor input[type=submit] {
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

  <form method="POST" id="enviarEmail" action="../navigation/nav.php">

  <label>Contrase&ntilde;a actual:</label> <input type="password" name="oldPassword" minlength="0" maxlength="32" required placeholder="Contrase&ntilde;a..."/><br>
  <label>Nueva contrase&ntilde;a:</label> <input type="password" name="newPassword" minlength="0" maxlength="32" required placeholder="Nueva contrase&ntilde;a..."/><br>


  <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/cambiarPassword.php"/>
  <input type="submit" value="Cambiar contrase&ntilde;a">
  </form>
</div>





<div id="footer">&nbsp;</div>
</div>
