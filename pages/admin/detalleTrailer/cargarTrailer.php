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
<div align="center" >
<div class="cuadro-listado" style="width:80vw;">

<?php

	if (isset($_POST['titulo'])){
      $_SESSION['titulo'] = $_POST['titulo'];
    }
    if (isset($_POST['descripcion'])){
      $_SESSION['descripcion'] = $_POST['descripcion'];
    }


	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.trailer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/pages/admin/detalleTrailer/class.consultaTrailer.php');

	$checktrailer = new TrailerDB();
	$checktrailer->setFiltro('titulo = "'.$_POST['titulo'].'"');
	$checktrailer->fetchRecordSet($conn);
	if ($checktrailer->getNextRecord()){
		echo '<h2>El titulo del trailer "'.$_POST['titulo'].'" ya existe. Elija otro por favor.</h2><br>';
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/cargarTrailerForm.php"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

// SUBIDA DE VIDEO
$video = null;
include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadVideo.php');
if ( (isset($uploadOk)) and ($uploadOk > 0))  {
	//imagen subio correctamente
	if ($uploadOk == 1) { $video = '/resources/video/videosSubidos/'.$newFileName; }

}else {

	if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
		//Si hubo un error al subir el video
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

}

// SUBIDA DE pdf
$pdf = null;
include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadPdf.php');
if ( (isset($uploadOk)) and ($uploadOk > 0))  {
	//imagen subio correctamente
	if ($uploadOk == 1) { $pdf = '/pdf/pdfFiles/'.$newFileName; }

}else {

	if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
		//Si hubo un error al subir el video
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

}


	$mensaje = '';

	$descripcion = $_POST['descripcion'];
	$titulo = $_POST['titulo'];
	$libAso = null;
	if (isset($_POST['idLib'])){
		$libAso = $_POST['idLib'];
	}

	if(strlen($descripcion) > 0 && strlen($titulo) > 0){
		$consultas = new ConsultasTrailer();
		$mensaje = $consultas->cargarTrailer($titulo, $descripcion, $video, $pdf, $libAso);
		$_SESSION['titulo'] = null;
		$_SESSION['descripcion'] = null;	
		echo '<!DOCTYPE html>
				<html>
				<head>
					<title></title>
				</head>
				<body>
					<h1>Trailer creado satisfactoriamente. Redireccionando al listado de trailers...</h1>
					<form name="redirect" method="post" action="../navigation/nav.php">
						<input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
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
			<input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
			<a onclick="this.parentNode.submit();"><button>Volver a Trailers</button></a>
		</form>




	</div>
</div>

