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

require_once $_SERVER['DOCUMENT_ROOT'].'/pages/admin/detalleLibro/class.consultaslibro.php';


if ((isset($_POST['fechaVencimiento']) && $_POST['fechaVencimiento'] != '') && (strtotime($_POST['fechaPublicacion'])>strtotime($_POST['fechaVencimiento']))){
  echo '<h1>Error: La fecha de vencimiento es anterior o igual a la fecha de publicacion.</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoComForm.php"/>
    <input type="hidden" name="bookId" value="'.$_POST['bookId'].'"/>
    <input type="hidden" name="fechaPublicacion" value="'.$_POST['fechaPublicacion'].'"/>
    <input type="hidden" name="fechaVencimiento" value="'.$_POST['fechaVencimiento'].'"/>
    <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
  </form>
  ';
  die();
}

// SUBIDA DE pdf
$pdf = null;
include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadPdf.php');
//include 'C:/wamp64/www/bookflix/resources/framework/class/class.uploadPdf.php';
if ( (isset($uploadOk)) and ($uploadOk > 0))  {
	//imagen subio correctamente
	if ($uploadOk == 1) { $pdf = '/resources/pdf/capitulos/'.$newFileName; }

}else {

	if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
		//Si hubo un error al subir el video
		echo '<form method="post" action="../../pages/navigation/nav.php">
	    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
	    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
	  </form>';
		die();
	}

}


	$mensaje = '';

  if (isset($_POST['fechaPublicacion'])){
    $fechaPublicacion = $_POST['fechaPublicacion'].' 10:10:10';
  }else{
    $fechaPublicacion = date('Y-m-d H:i:s');
  }
  $pathFile = '/pdf/pdfFiles/'.$newFileName;
  if (isset($_POST['fechaVencimiento'])){
    $fechaVencimiento = $_POST['fechaVencimiento'].' 10:10:10';
  }else{
    $fechaVencimiento = '2099-01-01 10:10:10';
  }

    $consultas = new ConsultasLibro();
      $id = $_POST['bookId'];
      if ($uploadOk == 1) {$consultas->modificarLibro('pathFile', $pathFile, $id);}
      $consultas->modificarLibro('fechaPublicacion', $fechaPublicacion, $id);
      $consultas->modificarLibro('fechaVencimiento', $fechaVencimiento, $id);
      $consultas->modificarLibro('porCapitulos', 0, $id);
      $conn->exec("DELETE FROM capitulos WHERE idLibro = ".$id); //Si se carga un libro entero se borran sus capitulos
      echo '<!DOCTYPE html>
          <html>
          <head>
            <title></title>
          </head>
          <body>
            <h1>Archivo subido satisfactoriamente. Redireccionando al listado de libros...</h1>
            <form name="redirect" method="post" action="../navigation/nav.php">
              <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
            </form>



            <script type="text/javascript">
              setTimeout(function(){document.forms["redirect"].submit()},4000);
            </script>
          </body>
          </html>';
?>

		<h2><?= $mensaje ?></h2><br>
		<form method="post">
			<input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
			<a onclick="this.parentNode.submit();"><button>Volver a Libros</button></a>
		</form>




	</div>
</div>
