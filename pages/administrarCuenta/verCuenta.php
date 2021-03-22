<?php
include_once "../../resources/framework/class/class.user.php";
include_once "../../resources/framework/class/class.perfil.php";
include_once "../../resources/framework/class/class.tarjeta.php";

$suscriptores = new UserDB();
$suscriptores->setFiltro("id = '".$_SESSION['id']."'");
$suscriptores->setOtros("LIMIT 1");

$suscriptores->fetchRecordSet($conn);
$suscriptor = $suscriptores->getNextRecord();
$valoresUser = $suscriptor->getValues();



if ($_SESSION['role'] != 'Admin'){

  $perfiles = new PerfilDB();
  $perfiles->setFiltro("idUsuario = '".$_SESSION['id']."'");

  $perfiles->fetchRecordSet($conn);

  $tarjetas = new TarjetaDB();

  $tarjetas->setFiltro("idUsuario = '".$_SESSION['id']."'");
  $tarjetas->setOtros("LIMIT 1");
  $tarjetas->fetchRecordSet($conn);
  $tarjeta = $tarjetas->getNextRecord();
  $valoresTarjeta = $tarjeta->getValues();
}

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

  <?php
  if ($_SESSION['role'] == 'Admin'){

    echo '<form method="POST" id="cambioPerfil" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/home/homeAdmin.php"/>
      <a onClick="this.parentNode.submit();"><button type="button"> Volver a menu </button></a>
    </form>';


  }else{

    echo '<form method="POST" id="cambioPerfil" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/login/seleccionPerfil.php"/>
      <a onClick="this.parentNode.submit();"><button type="button"> Volver a perfiles </button></a>
    </form>';
  }

  ?>


<br>
<h1>Bienvenido, <?= $valoresUser['nombre']." ".$valoresUser['apellido']?>.</h1><br>
<form method="POST" id="editarCuenta" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
  <a onClick="this.parentNode.submit();"><button type="button"> Modificar datos </button></a>
</form>

<div style="background-color:rgba(0,0,0,0.3);padding-left:10px;padding-top:10px;">
<label>Nombre de usuario: <?= $valoresUser['uLogin'] ?></label><br>
<label>Contrase&ntilde;a: ******** </label><br>
<label>DNI: <?=$valoresUser['dniTitular']?></label>
<br>


<label>Correo electr&oacute;nico: <?= $valoresUser['email'] ?></label><br>
</div>
<br>

<?php if ($_SESSION['role'] != 'Admin'){
?>
<h2>Perfiles: </h2><br>
<?php
while ($next = $perfiles->getNextRecord()){
  ?>
  <div style="background-color:rgba(0,0,0,0.3);padding-left:10px;padding-top:10px;">
  <img src="holaSoyUnLinkQueNoAnda" alt="Imagen de <?= $next->nombre ?>" onerror="this.src='../../resources/img/defaultProfile.jpeg'"/>&nbsp;
  <label><?= $next->getValues()['nombre'] ?></label> <a><button type="button">Ver perfil</button></a><br><br>
</div>
  <?php
}
?>
<br>
<h2>Detalles facturacion:</h2> <br>
<div style="background-color:rgba(0,0,0,0.3);padding-left:10px;padding-top:10px;">
<label>Nro tarjeta: ************<?= substr($tarjeta->nroTarjeta,-4)?></label><br>
<label>Plan de suscripcion: <?= ($valoresUser['uRole'] != 'premium')?'Com&uacute;n':'Premium' ?> </label><br>
</div>
<?php
}
?>
</div>





<div id="footer">&nbsp;</div>
</div>
