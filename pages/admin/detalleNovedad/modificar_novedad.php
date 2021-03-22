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


<?php

	if (isset($_POST['contenido'])){
      $_SESSION['contenido'] = $_POST['contenido'];
    }
    if (isset($_POST['titulo'])){
      $_SESSION['titulo'] = $_POST['titulo'];
    }
    if (isset($_POST['descripcion'])){
      $_SESSION['descripcion'] = $_POST['descripcion'];
    }

	require_once('class.consultasnovedad.php');
	require_once('../../resources/framework/DBconfig.php');


	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.novedad.php');

	$checkNovedad = new NovedadDB();
	$checkNovedad->setFiltro('titulo = "'.$_POST['titulo'].'"');
	$checkNovedad->fetchRecordSet($conn);
	if ($nove = $checkNovedad->getNextRecord()){
		if ($nove->idNovedad != $_POST["id"]){
		echo '<h2>El titulo de novedad "'.$_POST['titulo'].'" ya existe. Elija otro por favor.</h2><br>';
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/modificar.php"/>
	    <input type="hidden" name="idNovedad" value="'.$_POST["id"].'"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
		}
	}


	// SUBIDA DE IMAGEN
	$foto = '';
	include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadImage.php');
	if ( (isset($uploadOk)) and ($uploadOk > 0))  {
		//imagen subio correctamente
		if ($uploadOk == 1) { $foto = '/resources/img/imagenesSubidas/'.$newFileName; }

	}else {

		if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
			//Si hubo un error al subir la imagen
			echo '<form method="post" action="../../pages/navigation/nav.php">
		    <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
		    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
		  </form>';
			die();
		}

	}
	// SUBIDA DE VIDEO
	$video = '';
	include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadVideo.php');
	if ( (isset($uploadOk)) and ($uploadOk > 0))  {
		//imagen subio correctamente
		if ($uploadOk == 1) { $video = '/resources/video/videosSubidos/'.$newFileName; }

	}else {

		if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
			//Si hubo un error al subir el video
			echo '<form method="post" action="../../pages/navigation/nav.php">
		    <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
		    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
		  </form>';
			die();
		}

	}





	$mensaje = null;
	$consulta = new ConsultasNovedad();
	$contenido = $_POST['contenido'];
	$descripcion = $_POST['descripcion'];
	$titulo = $_POST['titulo'];
	$id = $_POST['id'];

	if(strlen($contenido) > 0 && strlen($descripcion) > 0 && strlen($titulo) > 0){
		$mensaje = $consulta->modificarNovedad("contenido",$contenido,$id);
		if (isset($_POST['uploadedImage']) and $_POST['uploadedImage'] != ''){$mensaje = $consulta->modificarNovedad("foto",$foto,$id);} //solo subir imagen si existe
		if (isset($_POST['uploadedVideo']) and $_POST['uploadedVideo'] != '') {$mensaje = $consulta->modificarNovedad("video",$video,$id);} //solo subir video si existe
		$mensaje = $consulta->modificarNovedad("descripcion",$descripcion,$id);
		$mensaje = $consulta->modificarNovedad("titulo",$titulo,$id);
		echo '<!DOCTYPE html>
					<html>
					<head>
						<title></title>
					</head>
					<body>

						<h1>Novedad modificada coreectamente. Redireccionando al listado de novedades...</h1>
						<form name="redirect" method="post" action="../navigation/nav.php">
							<input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
						</form>



						<script type="text/javascript">
							setTimeout(function(){document.forms["redirect"].submit()},4000);
						</script>

					</body>
					</html>';
	}
	else {
		echo "Por favor complete todos los campos.";
	}

?>
