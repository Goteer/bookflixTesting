<?php
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.perfil.php");
$perfiles = new PerfilDB();
$perfiles->setFiltro("idUsuario = '".$_SESSION['id']."'");
$perfiles->fetchRecordSet($conn);
$cant = $conn->query("SELECT COUNT(*) FROM perfiles WHERE idUsuario = '".$_SESSION['id']."'");
if (!$cant = $cant->fetchColumn()){
	die("Error de base de datos al cargar perfiles. Intente nuevamente.");
}
?>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<br>
<div align="center">



<h1> &iquest;Qui&eacute;n est&aacute; usando Bookflix? </h1><br>
<div class="perfiles" align="center" style="margin:0 30px;">
<?php
	while ($next = $perfiles->getNextRecord()){

?>
	<?php
	if ($cant > 1){
	?>
	<form id="borrarPerfil_<?=$next->idPerfil?>" style="display:none" method="post" action="../navigation/nav.php">
		<input type="hidden" name="target_page" value="/pages/administrarCuenta/eliminarPerfil.php"/>
		<input type="hidden" name="idPerfil" value="<?=$next->idPerfil?>"/>
		<input type="hidden" name="nombrePerfil" value="<?=$next->nombre?>"/>
	</form>
	<?php } ?>


		<form style="display:inline" method="post" action="../navigation/nav.php">
			<input type="hidden" name="target_page" value="/pages/login/class/logProfileIn.php"/>
			<input type="hidden" name="idPerfil" value="<?= $next->idPerfil ?>"/>
      <input type="hidden" name="nombrePerfil" value="<?= $next->nombre ?>"/>
			<a title="<?= $next->nombre ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
			<img src="holaSoyUnLinkQueNoAnda" alt="<?= $next->nombre ?>" onerror="this.src='../../resources/img/defaultProfile.jpeg'"/>
		</a>
		<h3 class="title"><?= $next->nombre ?> <?php echo ($cant > 1)?'<button type="button" class="boton" style="float:right" onclick="document.getElementById(\'borrarPerfil_'.$next->idPerfil.'\').submit();"><i class="fa fa-trash-o"></i></button>':'' ?> </h3>

		</form>



<?php
	}

if ( (($_SESSION['role'] == 'suscriptor') and ($cant < 2)) or (($_SESSION['role'] == 'premium') and ($cant < 4)) )  { //Si esta debajo del maximo de perfiles...
?>

<form style="display:inline" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/agregarPerfil.php"/>
  <a title="Agregar un perfil" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
  <img src="../../resources/img/addProfile.jpeg" alt="<?= $next->nombre ?>"/>
  <h3 class="title">Nuevo Perfil</h3>
  </a>
</form>

<?php

}
?>


</div>



</div>
