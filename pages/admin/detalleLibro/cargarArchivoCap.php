<style>
button {
  background-color: #555555;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.cuadro-listado {
  margin: 15px 0;
  background-image: linear-gradient(to bottom,#444, #222);
  padding-top:10px;
  padding-bottom:10px;
  width:80%;
}

</style>

<br>

<form method="post" style="display:none" id="errorForm">
  <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoCapForm.php"/>
  <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
  <input type="hidden" name="nroCapitulo" value="<?=$_POST['nroCapitulo']?>"/>
  <input type="hidden" name="fechaPublicacion" value="<?=$_POST['fechaPublicacion']?>"/>
  <input type="hidden" name="fechaVencimiento" value="<?=$_POST['fechaVencimiento']?>"/>
  <input type="hidden" name="capFinal" value="<?=$_POST['capFinal']?>"/>
</form>

<div align="center" >
<div class="cuadro-listado" style="width:80vw;">

<?php

	//require_once 'C:/wamp64/www/bookflix/resources/framework/class/class.capitulo.php';
	//require_once 'C:/wamp64/www/bookflix/pages/admin/detalleLibro/class.consultaCapitulo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/pages/admin/detalleLibro/class.consultaCapitulo.php';

$libroMarcadoPorCapitulos = $conn->query("SELECT porCapitulos from libros WHERE idLibro = ".$_POST['bookId']);
$libroMarcadoPorCapitulos = $libroMarcadoPorCapitulos->fetchColumn();
$cantCapitulos = $conn->query("SELECT COUNT(DISTINCT nroCapitulo) from capitulos WHERE idLibro = ".$_POST['bookId']);
$cantCapitulos = $cantCapitulos->fetchColumn();
$libroTienePdf = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']." AND pathFile IS NOT NULL AND pathFile != '' AND pathfile != '/'");

if (!isset($_POST['capFinal']) || $_POST['capFinal'] != 1){ $_POST['capFinal'] = 0;} //Si no se fijo capFinal, asegurarse de que es el valor falso correcto.
$nroUltimoCap = $conn->query("SELECT MAX(nroCapitulo) FROM capitulos WHERE idLibro = '".$_POST['bookId']."'");
$nroUltimoCap = $nroUltimoCap->fetchColumn();



if (!$libroMarcadoPorCapitulos && $libroTienePdf->fetch()){ //Si el libro no esta marcado por capitulos y tiene un pdf asociado al libro entero
  ?>
  <h1>Error, este es un libro entero ya cargado. No se puede cargar capitulo.</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
    <a type="button" onClick="this.parentNode.submit();"><button>Volver a Libros</button></a>
  </form>
  <?php
  die();
}



if (!$libroMarcadoPorCapitulos && $cantCapitulos == 0){ //Si no esta marcado por capitulos, pero no tiene pdf ni capitulos ya cargados
  //marcar libro como "por capitulos"
  if ( !( $conn->query("UPDATE libros SET porCapitulos = 1 WHERE idLibro = ".$_POST['bookId']) )  ) {
    //Si no se pudo marcar
    ?>
    <h1>Error, no se pudo preparar el libro para ser cargado por capitulos.</h1><br>
    <button type="button" onClick="document.getElementById('errorForm').submit();">Volver</button>
    <?php
    die();
  }
  //Si se pudo marcar, continuar...
}


  $checkcapitulo = $conn->query("SELECT * FROM capitulos WHERE nroCapitulo = ".$_POST['nroCapitulo']." AND idLibro = ".$_POST['bookId']);
	if ($checkcapitulo->fetch()){
		?>
    <h2>El numero de capitulo <?=$_POST['nroCapitulo']?> ya existe. Elija otro por favor.</h2><br>
    <button type="button" onClick="document.getElementById('errorForm').submit();">Volver</button>
    <?php
		die();
	}

  if ($_POST['capFinal'] == 1 && $_POST['nroCapitulo'] < $nroUltimoCap){
    ?>
    <h2>El numero de capitulo <?=$_POST['nroCapitulo']?> no es el ultimo numericamente, no puede marcarlo como final.</h2><br>
    <button type="button" onClick="document.getElementById('errorForm').submit();">Volver</button>
    <?php
		die();
  }


  if ((isset($_POST['fechaVencimiento']) && $_POST['fechaVencimiento'] != '') && (strtotime($_POST['fechaPublicacion'])>strtotime($_POST['fechaVencimiento']))){
    ?>
    <h1>Error: La fecha de vencimiento es anterior o igual a la fecha de publicacion.</h1><br>
    <button type="button" onClick="document.getElementById('errorForm').submit();">Volver</button>
    <?php
    die();
  }

// SUBIDA DE pdf
$pdf = null;
include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadPdf.php');
//include 'C:/wamp64/www/bookflix/resources/framework/class/class.uploadPdf.php';
if ( (isset($uploadOk)) and ($uploadOk > 0))  {
	//imagen subio correctamente
	if ($uploadOk == 1) { $pdf = '/resources/pdf/pdfFiles/'.$newFileName; }

}else {

	if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
		//Si hubo un error al subir el video
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
	    <a type="button" onClick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

}

if ($_POST['capFinal'] == 1 && $uploadOk == 2){
  ?>
  <h2>No puede marcar como final un capitulo sin archivo.</h2><br>
  <button type="button" onClick="document.getElementById('errorForm').submit();">Volver</button>
  <?php
  die();
}


	$mensaje = '';

	if (isset($_POST['idLib'])){
		$libAso = $_POST['idLib'];
	}
	$nroCapitulo = $_POST['nroCapitulo'];
	$pathFile = '/pdf/pdfFiles/'.$newFileName;
  $fechaPublicacionInput = (isset($_POST['fechaPublicacion']) && $_POST['fechaPublicacion'] != '')?$_POST['fechaPublicacion']:date("Y-m-d H:i:s");
  $fechaVencimientoInput = (isset($_POST['fechaVencimiento']) && $_POST['fechaVencimiento'] != '')?$_POST['fechaVencimiento']:date("Y-m-d H:i:s",strtotime("2037-01-01"));

	if(strlen($pathFile) > 0 && isset($nroCapitulo)){
		$consultas = new ConsultasCapitulo();
		$mensaje = $consultas->cargarCapitulo($_POST['bookId'], $nroCapitulo, $pathFile, $_POST['capFinal'], $fechaPublicacionInput, $fechaVencimientoInput);
		echo '<!DOCTYPE html>
				<html>
				<head>
					<title></title>
				</head>
				<body>
					<h1>Capitulo creado satisfactoriamente. Redireccionando al listado de libros...</h1>
					<form name="redirect" method="post" action="../navigation/nav.php">
						<input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
					</form>



					<script type="text/javascript">
						setTimeout(function(){document.forms["redirect"].submit()},4000);
					</script>
				</body>
				</html>';
	}
	else{
		echo "Falta completar campos. Los campos requeridos son: Titulo y descripcion.";
	}
?>

		<h2><?= $mensaje ?></h2><br>
		<form method="post">
			<input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
			<a type="button" onClick="this.parentNode.submit();"><button>Volver a Libros</button></a>
		</form>




	</div>
</div>
