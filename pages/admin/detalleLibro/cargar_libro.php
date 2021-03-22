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

	if (isset($_POST['nombre'])){
      $_SESSION['nombre'] = $_POST['nombre'];
    }
    if (isset($_POST['isbn'])){
      $_SESSION['isbn'] = $_POST['isbn'];
    }
    if (isset($_POST['descripcion'])){
      $_SESSION['descripcion'] = $_POST['descripcion'];
    }
    if (isset($_POST['idGenero'])){
      $_SESSION['idGenero'] = $_POST['idGenero'];
    }
    if (isset($_POST['idAutor'])){
      $_SESSION['idAutor'] = $_POST['idAutor'];
    }
    if (isset($_POST['idEditorial'])){
      $_SESSION['idEditorial'] = $_POST['idEditorial'];
    }

	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.libro.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/pages/admin/detalleLibro/class.consultaslibro.php');

	$checkLibro = new LibroDB();
	if ($_POST['nombreModif'] != $_POST['nombre']) {//al modificar si el nombre es igual al que ya tenia no da error
			$checkLibro->resetFiltro();
			$checkLibro->setFiltro('nombre = "'.$_POST['nombre'].'"');
			$checkLibro->fetchRecordSet($conn);
			while ($record = $checkLibro->getNextRecord()) {
				if ($record->nombre == $_POST['nombre']) {
					echo '<h2>El nombre de libro "'.$_POST['nombre'].'" ya existe. Elija otro por favor.</h2><br>';
					echo '<form method="post" action="../../pages/navigation/nav.php">
				    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/'.((isset($_POST['action']))?'editar':'cargar').'_libro_form.php"/>
				    <input type="hidden" name="bookId" value="'.$_POST["bookId"].'"/>
				    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
					</form>';
					die();
				}

			}
	}

	//comprueba que el isbn no este repetido
	if ($_POST['isbnModif'] != $_POST['isbn']) {//al modificar si el isbn es igual al que ya tenia no da error
		$checkLibro->resetFiltro();
		$checkLibro->setFiltro('isbn = "'.$_POST['isbn'].'"');
		$checkLibro->fetchRecordSet($conn);
		while ($record = $checkLibro->getNextRecord()) {
			if ($record->isbn == $_POST['isbn']){
				echo '<h2>El isbn "'.$_POST['isbn'].'" ya existe en otro libro. Ingrese otro por favor.</h2><br>';
				echo '<form method="post" action="../../pages/navigation/nav.php">
			    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/'.((isset($_POST['action']))?'editar':'cargar').'_libro_form.php"/>
			    <input type="hidden" name="bookId" value="'.$_POST["bookId"].'"/>
          <input type="hidden" name=""
			    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
				</form>';
				die();
			}
		}
	}

	//comprueba que el isbn sea de 10 o 13 digitos

	if ((strlen($_POST['isbn']) != 10) && (strlen($_POST['isbn']) != 13)) {
		echo '<h2>El isbn de libro "'.$_POST['nombre'].'" debe ser de 10 o 13 digitos. Ingrese otro por favor.</h2><br>';
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/'.((isset($_POST['action']))?'editar':'cargar').'_libro_form.php"/>
	    <input type="hidden" name="bookId" value="'.$_POST["bookId"].'"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

// SUBIDA DE IMAGEN


$foto = '';
include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadImage.php');
if ( (isset($uploadOk)) and ($uploadOk > 0))  {
	//imagen subio correctamente
	if ($uploadOk == 1) { $foto = '/resources/img/imagenesSubidas/'.$newFileName; }

}else {

	if ( (isset($uploadOk)) and ($uploadOk == 0) and !(  isset($_POST['action']) and $_POST['action'] == 'modificar')) {
		//Si hubo un error al subir la imagen
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';

		die();
	}

}

 	$_SESSION['isbn'] = null;
 	$_SESSION['nombre'] = null;
 	$_SESSION['descripcion'] = null;
	$_SESSION['idAutor'] = null;
    $_SESSION['idEditorial'] = null;
    $_SESSION['idGenero'] = null;

	$mensaje = '';

	$descripcion = $_POST['descripcion'];
	$nombre = $_POST['nombre'];
  $idAutor = $_POST['idAutor'];
  $idEditorial = $_POST['idEditorial'];
  $idGenero = $_POST['idGenero'];
  $isbn = $_POST['isbn'];

	if(strlen($descripcion) > 0 && strlen($nombre) > 0){
		$consultas = new ConsultasLibro();
	    if (isset($_POST['bookId']) and isset($_POST['action']) and $_POST['action'] == 'modificar'){ //Si se estaba editando...
	      $id = $_POST['bookId'];
	      $consultas->modificarLibro('nombre', $nombre, $id);
	      $consultas->modificarLibro('descripcion', $descripcion, $id);
	      if ($uploadOk == 1) {$consultas->modificarLibro('foto', $foto, $id);} //Si se subio una nueva foto, cambiarla
	      $consultas->modificarLibro('idAutor', $idAutor, $id);
	      $consultas->modificarLibro('idEditorial', $idEditorial, $id);
	      $consultas->modificarLibro('idGenero', $idGenero, $id);
	      $consultas->modificarLibro('isbn', $isbn, $id);
	      $accion='modificado';
	    }else{// si se estaba creando...
	      $mensaje = $consultas->cargarLibro($nombre,$descripcion, $foto,date("Y-m-d"),'2025-01-01',$idAutor,$idEditorial,$idGenero,$isbn);
	      $accion='creado';
	    }
			echo '<!DOCTYPE html>
					<html>
					<head>
						<title></title>
					</head>
					<body>
						<h1>Libro '.$accion.' satisfactoriamente. Redireccionando al listado de libros...</h1>
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
			<input type="hidden" name="target_page" value="/pages/home/homeAdmin.php"/>
			<a onclick="this.parentNode.submit();"><button>Volver al menu</button></a>
		</form>




	</div>
</div>
