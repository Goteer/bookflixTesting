<?php
	require_once('class.consultasnovedad.php');	
	$id = $_POST['novedadID'];

	$consulta = new ConsultasNovedad();
	$mensaje = $consulta->eliminarNovedad($id);
?>
<div align="center" >
	<div style="background-color:#222;width:80vw;">
	<?= $mensaje ?>
</div>
</div>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Novedad eliminada satisfactoriamente. Redireccionando al listado de novedades...</h1>

	<form name='redirect' method="post" action="../navigation/nav.php">
		<input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
	</form>

	<script type="text/javascript">
		setTimeout(function(){document.forms['redirect'].submit()},4000);
	</script>
