<?php
	require_once('class.consultaTrailer.php');	
	$id = $_POST['trailerID'];

	$consulta = new ConsultasTrailer();
	$mensaje = $consulta->eliminarTrailer($id);
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
	<h1>Trailer eliminado satisfactoriamente. Redireccionando al listado de trailers...</h1>

	<form name='redirect' method="post" action="../navigation/nav.php">
		<input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
	</form>

	<script type="text/javascript">
		setTimeout(function(){document.forms['redirect'].submit()},4000);
	</script>
