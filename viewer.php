<!DOCTYPE html>
<html lang="es">
<head>
	<title>Libro prueba</title>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/turn.min.js"></script>
	<script type="text/javascript" src="js/dragscroll.js"></script>
	<link rel="stylesheet" href="../../resources/framework/mainStyle.css">
	<script src="js/pdf.min.js"></script>
	<meta charset="UTF-8" />

	<?php
	include_once "resources/framework/class/class.libro.php";
	include_once "resources/framework/DBconfig.php";
	$libros = new LibroDB();
	?>

</head>


<body style="display:block;">



<div>

<div align="center">
	<button id="prev-page">Anterior</button> <button id="goto-page">Ir a pag:</button> <input type="number" name= "gotoPageTarget" id="gotoPageTarget" value='0'></input> <button id="next-page">Siguiente</button>
	<button id="zoom-in">Zoom +</button> <button id="zoom-out">Zoom -</button>
</div>
<hr>
<div  align="center">
	<div id="flipbook" style="max-height:95vh;max-width:100vx;">
	</div>
</div>
</div>



<?php

$libros->setFiltro('idLibro = '.$_POST['bookID']);
$libros->setOtros('LIMIT 1');
$libros->fetchRecordSet($conn);
if ($libro = $libros->getNextRecord()){
	$url = $libro->pathFile;
	$imagenTapa = $libro->foto;
}else{
	$url = '';
	$imagenTapa = '';
}

?>
<script src="pdf/build/pdf.js"></script>
<script src="js/main.js" url="<?= $url ?>" tapa="<?= $imagenTapa ?>"></script>


</body>
