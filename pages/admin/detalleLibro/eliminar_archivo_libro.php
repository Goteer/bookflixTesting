<?php

	include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
	require_once('class.consultaslibro.php');
	$id = $_POST['bookId'];

	$auxSql = "SELECT porCapitulos,pathFile from libros where idLibro = $id";
	$statement = $conn->prepare($auxSql);
	$statement->bindParam(':idLibro',$id);
	$statement->execute();
	$aux = $statement->fetch();

	$consulta = new ConsultasLibro();
	$mensaje = $consulta->modificarLibro("pathFile",null,$id);

	


	


	$tabla = "historial";
	$sql = "DELETE FROM $tabla where idLibro = $id";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	if (!$statement){
		echo "Erro al borrar el elemento con id: $id";
	}
	else{
		$statement->execute();
	}

	$tabla = "librosterminados";
	$sql = "DELETE FROM $tabla where idLibro = $id";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	if (!$statement){
		echo "Erro al borrar el elemento con id: $id";
	}
	else{
		$statement->execute();
	}


	$tabla = "favoritos";
	$sql = "DELETE FROM $tabla where idLibro = $id";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	if (!$statement){
		echo "Erro al borrar el elemento con id: $id";
	}
	else{
		$statement->execute();
	}


?>
<div align="center" >
	<div style="background-color:#222;width:80vw;">

</div>
</div>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if ($aux["porCapitulos"] == 0) {
		if ($aux["pathFile"] != ""){ ?>

			<h1>Archivo eliminado satisfactoriamente. Redireccionando al listado de libros...</h1>

	<?php } else {
				echo "<h1>El libro no tiene un Archivo.</h1>";
			} }
	else{ ?>
	<h1>El archivo fue subido por Capitulos, edite los capitulos para eliminarlo. Redireccionando.</h1>

	<?php }  ?>

	<form name='redirect' method="post" action="../navigation/nav.php">
		<input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
	</form>

	<script type="text/javascript">
		setTimeout(function(){document.forms['redirect'].submit()},4000);
	</script>
