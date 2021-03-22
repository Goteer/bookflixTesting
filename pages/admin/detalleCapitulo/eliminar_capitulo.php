<?php
	$id = $_POST['bookId'];
	$capitulo = $_POST['nroCapitulo'];

	include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";

	$auxSql = "SELECT COUNT(idLibro) as cantidad from capitulos where idLibro = $id";
	$statement = $conn->prepare($auxSql);
	$statement->bindParam(':idLibro',$id);
	$statement->execute();
	$aux = $statement->fetch();


	$tabla = "capitulos";
	$sql = "DELETE FROM $tabla where idLibro = $id and nroCapitulo = $capitulo";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	$statement->bindParam(':nroCapitulo',$capitulo);
	if (!$statement){
		echo "Error al borrar el capitulo: $capitulo";
	}
	else{
		$statement->execute();
	}
	$num = 1;
	$sql = "UPDATE $tabla set esCapituloFinal = 0 where idLibro = $id and esCapituloFinal = 1";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	$statement->bindParam(':esCapituloFinal',$num);
	$statement->execute();



	if ($aux["cantidad"] == 1){

		$num = 0;
		$sql = "UPDATE libros set porCapitulos = 0 where idLibro = $id and porCapitulos = 1";
		$statement = $conn->prepare($sql);
		$statement->bindParam(':idLibro',$id);
		$statement->bindParam(':porCapitulos',$num);
		$statement->execute();
	}

	$tabla = "historial";
	$sql = "DELETE FROM $tabla where capitulo = $capitulo and idLibro = $id";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':capitulo',$capitulo);
	$statement->bindParam(':idLibro',$id);
	if (!$statement){
		echo "Error al borrar el capitulo: $capitulo";
	}
	else{
		$statement->execute();
	}

	$tabla = "librosterminados";
	$sql = "DELETE FROM $tabla where idLibro = $id";
	$statement = $conn->prepare($sql);
	$statement->bindParam(':idLibro',$id);
	if (!$statement){
		echo "Error al borrar el libro con id: $id";
	}
	else{
		$statement->execute();
	}


?>
<br>
<div align="center" >
	<div id="content-box" style="width:80vw;">


	<h2>Capitulo eliminado satisfactoriamente. Redireccionando al listado de capitulos...</h2>

	<form name='redirect' method="post" action="../navigation/nav.php">
		<input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
		<input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
	</form>

</div>
</div>
	<script type="text/javascript">
		setTimeout(function(){document.forms['redirect'].submit()},2000);
	</script>
