<form id="volverForm" method="post" action="../navigation/nav.php" style="display:none">
	<input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/editarCapituloForm.php"/>
	<input type="hidden" name="bookId" value="<?= $_POST['bookId'] ?>"/>
  <input type="hidden" name="nroCapitulo" value="<?= $_POST['nroCapitulo'] ?>"/>
  <input type="hidden" name="newNroCapitulo" value="<?= $_POST['newNroCapitulo'] ?>"/>
  <input type="hidden" name="fechaPublicacion" value="<?= $_POST['fechaPublicacion'] ?>"/>
  <input type="hidden" name="fechaVencimiento" value="<?= $_POST['fechaVencimiento'] ?>"/>
  <input type="hidden" name="capFinal" value="<?= $_POST['capFinal'] ?>"/>
</form>

<form id="exitoForm" method="post" action="../navigation/nav.php" style="display:none">
	<input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
	<input type="hidden" name="bookId" value="<?= $_POST['bookId'] ?>"/>
</form>
<br>
<div align="center" >
  <div id="content-box" style="width:50vw">


<?php

$uploadOk = 0;
$pathFile = '';
if (isset($_FILES['uploadedPdf'])){

  $pdf = null;
  include($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.uploadPdf.php');
  //include 'C:/wamp64/www/bookflix/resources/framework/class/class.uploadPdf.php';
  if ( (isset($uploadOk)) and ($uploadOk > 0))  {
    // subio correctamente
    if ($uploadOk == 1) { $pathFile = '/pdf/pdfFiles/'.$newFileName; }

  }else {

    if ( (isset($uploadOk)) and ($uploadOk == 0) ) {
      //Si hubo un error al subir
      echo '<form method="post" action="../../pages/navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
        <a onclick="this.parentNode.submit();"><button>Volver</button></a>
      </form>';
      die();
    }

  $pathFile = '/pdf/pdfFiles/'.$newFileName;
	}

}


  if (!isset($_POST['capFinal']) || $_POST['capFinal'] != 1){ $_POST['capFinal'] = 0;} //Si no se fijo capFinal, asegurarse de que es el valor falso correcto.

  $nroCapituloYaExiste = false;
  $finalNoEsUltimo = false;
  $noEsUltimo = false;
  $mayorAlUltimoCap = false;
  $nroUltimoCap = -1;

  $capitulos = $conn->query("SELECT * FROM capitulos WHERE idLibro = '".$_POST['bookId']."'");
  while ($next = $capitulos->fetch()){
    if (($next['nroCapitulo'] == $_POST['newNroCapitulo']) && ($next['nroCapitulo'] != $_POST['nroCapitulo'])){ //Reviso si ya existe el numero de capitulo. Esta busqueda excluye el numero original de capitulo
      $nroCapituloYaExiste = true;
    }

    if (($next['nroCapitulo']>$_POST['newNroCapitulo'])){ //Si es final pero no es ultimo numericamente
      $noEsUltimo = true;
    }

    if ($nroUltimoCap <= $next['nroCapitulo']){
      $nroUltimoCap = $next['nroCapitulo'];
    }


  } //Fin while

  if (($_POST['tieneFinal'] == 1) && ($_POST['newNroCapitulo'] > $nroUltimoCap) && $nroUltimoCap != $_POST['nroCapitulo']){
    $mayorAlUltimoCap = true; //En un libro finalizado se intenta modificar un capitulo para que este mas adelante que el ultimo.
  }

  if ($noEsUltimo && ($_POST['capFinal'] == 1) && $nroUltimoCap && $nroUltimoCap != $_POST['nroCapitulo']){
    $finalNoEsUltimo = true;
  }



  if ($nroCapituloYaExiste ||  $finalNoEsUltimo ||  $mayorAlUltimoCap){
    echo "<h2>No se pudo modificar el capitulo por la siguiente razon:<br></h2>";
    if ($nroCapituloYaExiste) echo "<h2>-El n&uacute;mero de capitulo elegido ya existe.</h2><br>";
    if ($finalNoEsUltimo) echo "<h2>-Marc&oacute; como final al capitulo pero no es num&eacute;ricamente el ultimo capitulo.</h2><br>";
    if ($mayorAlUltimoCap) echo "<h2>-Ingres&oacute; un n&uacute;mero de capitulo mayor al ultimo capitulo en un libro finalizado.</h2><br>";
    ?>
    <button class="botonLeer" type="button" onclick="document.getElementById('volverForm').submit();">Volver al capitulo</button>
    <br>&nbsp;
    <?php

  }else{

    if ($uploadOk == 1){
      $query = "UPDATE capitulos SET
        nroCapitulo = '".$_POST['newNroCapitulo']."'
        , esCapituloFinal = '".$_POST['capFinal']."'
        , fechaPublicacion = '".$_POST['fechaPublicacion']."'
        , fechaVencimiento = '".$_POST['fechaVencimiento']."'
        , pathFile = ".$conn->quote($pathFile)."
        WHERE idLibro = '".$_POST['bookId']."' AND nroCapitulo = '".$_POST['nroCapitulo']."';";
    }else{
      $query = "UPDATE capitulos SET
        nroCapitulo = '".$_POST['newNroCapitulo']."'
        , esCapituloFinal = '".$_POST['capFinal']."'
        , fechaPublicacion = '".$_POST['fechaPublicacion']."'
        , fechaVencimiento = '".$_POST['fechaVencimiento']."'
        WHERE idLibro = '".$_POST['bookId']."' AND nroCapitulo = '".$_POST['nroCapitulo']."';";
    }

    if ($conn->exec($query)){

			$conn->exec("DELETE FROM historial WHERE idLibro = '".$_POST['bookId']."' AND capitulo = '".$_POST['nroCapitulo']."';
									 DELETE FROM librosterminados WHERE idLibro = ".$_POST['bookId'].";");

			if ($_POST['tieneFinal'] == 1 && $_POST['capFinal'] != 1){ //Si no modificamos el ultimo capitulo:

				$conn->exec("UPDATE capitulos SET esCapituloFinal = '0'
										 	WHERE idLibro = '".$_POST['bookId']."' AND nroCapitulo = '".$nroUltimoCap."';");
				//Quitar la marca de ultimo capitulo al ultimo.
						echo "<h2>Se modific&oacute; el capitulo correctamente.<br></h2>";
					echo '<script type="text/javascript">
										setTimeout(function(){document.forms["exitoForm"].submit()},2000);
									</script>';

			}else{//Si modificamos el ultimo capitulo, ya terminamos.
				echo "<h2>Se modific&oacute; el capitulo correctamente.<br></h2>";
				echo '<script type="text/javascript">
								setTimeout(function(){document.forms["exitoForm"].submit()},2000);
							</script>';
			}


    }else{
      echo "<h2>No se realiz&oacute; ningun cambio. Volviendo al capitulo...<br></h2>";
      echo '<script type="text/javascript">
    		      setTimeout(function(){document.forms["volverForm"].submit()},3000);
    	      </script>';
    }


  }


 ?>


  </div>
</div>
