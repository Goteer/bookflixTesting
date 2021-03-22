
<head>
	<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="/js/turn.min.js"></script>
	<script type="text/javascript" src="/js/dragscroll.js"></script>
	<link rel="stylesheet" href="../../resources/framework/mainStyle.css">
	<script src="/js/pdf.min.js"></script>
	<meta charset="UTF-8" />
	<?php
	include_once "resources/framework/class/class.libro.php";
	include_once "resources/framework/DBconfig.php";
	$libros = new LibroDB();
	?>
</head>



<body style="display:block;">
	<form method="POST" id="volverError" action="../navigation/nav.php">
	  <input type="hidden" name="target_page" value="/pages/home/home.php"/>
	</form>
<br>

<div>

<div align="center">
	<form method="POST" id="volverError" action="../navigation/nav.php" style="display:inline; float:left; margin-left:10px">
		<input type="hidden" name="target_page" value="/pages/detalleTrailer/ver_trailer.php"/>
		<input type="hidden" name="idTrailer" value="<?= $_POST['trailerID']?>"/>
		<button class="boton" onclick="this.parentNode.submit();">Volver al trailer</button>
	</form>
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

if (isset($_POST['trailerID'])){
	include_once "resources/framework/class/class.trailer.php";
	$trailer = new TrailerDB();
	$trailer->setFiltro('idTrailer = '.$_POST['trailerID']);
	$trailer->setOtros('LIMIT 1');
	$trailer->fetchRecordSet($conn);
	if ($tra = $trailer->getNextRecord()){
		$url = $tra->pdf;
	}else{
		$url = '';
	}
}
else{


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

	}
	?>

<script src="/pdf/build/pdf.js"></script>
<script src="/js/main.js" url="<?= $url ?>" tapa="<?= $imagenTapa ?>"></script>

</body>
