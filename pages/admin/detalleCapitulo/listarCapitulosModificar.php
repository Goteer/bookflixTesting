<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<br>
<br>
<div style="margin-left:10px">
<form method="post" action="../navigation/nav.php" style="display:inline">
	<input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
	<input type="hidden" name="bookId" value="<?= $_POST['bookId'] ?>"/>
	<input type="hidden" name="sort" value="<?= $_POST['sort'] ?>"/>
	<button class="boton" onclick="this.parentNode.submit();">Volver al listado de libros</button>
</form></div>
<div align="center"> <div class="cuadro-listado">

<?php

$page = (isset($_POST['page']))?($_POST['page']):(0);

$queryCount = $conn->query("SELECT COUNT(*) from capitulos WHERE idLibro = ".$_POST['bookId']." ORDER BY nroCapitulo ASC");

$cantidadTotal = $queryCount->fetchColumn();

if ($cantidadTotal>0) {

$capitulosPorPagina = 9;
$cantPaginas = ceil($cantidadTotal/$capitulosPorPagina);


$capitulos = $conn->query("SELECT * from capitulos WHERE idLibro = ".$_POST['bookId']." ORDER BY nroCapitulo ASC LIMIT ".$capitulosPorPagina." OFFSET ".($capitulosPorPagina*$page));



?>

<div class="novedades" style="margin:0 30px;">
<?php
	while ($next = $capitulos->fetch()){
?>
		<form method="post" action="../navigation/nav.php">
			<input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/editarCapituloForm.php"/>
			<input type="hidden" name="nroCapitulo" value="<?= $next['nroCapitulo'] ?>"/>
			<input type="hidden" name="bookId" value="<?= $next['idLibro'] ?>"/>

			<a title="Cap&iacute;tulo <?= $next['nroCapitulo'] ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
			<i style="font-size:64px;margin-top:10px;" class="fa fa-book"></i>
<?php
		if (strtotime($next['fechaVencimiento'])<time()){ //Si esta vencido
?>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br> Expirado</h3>
<?php
		}elseif (strtotime($next['fechaPublicacion'])>time()){ //Si no es publico aun
?>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br> Proximamente</h3>
<?php
		}else{ //Si esta disponible
?>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br> Disponible</h3>
<?php
		}
	?>
	</a>
	</form>
<?php

	}//fin while de registros



?>
</div>

<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
      <input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page + 1 ?> de <?=$cantPaginas?>. Capitulos totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
      <input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  }

?>
</div>
<?php }else{
	echo "<h1>Este libro no es por capitulos o no contiene capitulos.</h1>";
}
?>
</div> </div>
