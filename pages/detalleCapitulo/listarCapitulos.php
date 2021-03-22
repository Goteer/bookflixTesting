<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<br>
<div style="margin-left:10px">
<form method="post" action="../navigation/nav.php" style="display:inline">
	<input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
	<input type="hidden" name="bookID" value="<?= $_POST['bookID'] ?>"/>
	<button class="boton" onclick="this.parentNode.submit();">Volver al libro</button>
</form></div>
<br>

<div align="center"> <div class="cuadro-listado">

<?php

$page = (isset($_POST['page']))?($_POST['page']):(0);

$queryCount = $conn->query("SELECT COUNT(*) from capitulos WHERE idLibro = ".$_POST['bookID']." ORDER BY nroCapitulo ASC");

$cantidadTotal = $queryCount->fetchColumn();

if ($cantidadTotal>0) {

$capitulosPorPagina = 9;
$cantPaginas = ceil($cantidadTotal/$capitulosPorPagina);


$capitulos = $conn->query("SELECT * from capitulos WHERE idLibro = ".$_POST['bookID']." ORDER BY nroCapitulo ASC LIMIT ".$capitulosPorPagina." OFFSET ".($capitulosPorPagina*$page));



?>

<div class="novedades" style="margin:0 30px;">
<?php
	while ($next = $capitulos->fetch()){
		if (strtotime($next['fechaVencimiento'])<time()){ //Si esta vencido
			?>
			<div style="background-image:linear-gradient(to bottom,#222, #0A0A0A);color:gray">
				<input type="hidden" name="target_page" value="/viewer.php"/>
				<input type="hidden" name="nroCapitulo" value="<?= $next['nroCapitulo'] ?>"/>
	      <input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

				<a title="Cap&iacute;tulo <?= $next['nroCapitulo'] ?>" onclick="alert('Este capitulo no esta disponible.')" style="color:inherit;text-decoration:inherit;">
				<i style="font-size:64px;margin-top:10px;" class="fa fa-book"></i>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br>Expirado</h3>
				</a>
			</div>
			<?php
		}elseif (strtotime($next['fechaPublicacion'])>time()){ //Si no es publico aun
			?>
			<div style="background-image:linear-gradient(to bottom,#222, #0A0A0A);color:gray">
				<input type="hidden" name="target_page" value="/viewer.php"/>
				<input type="hidden" name="nroCapitulo" value="<?= $next['nroCapitulo'] ?>"/>
	      <input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

				<a title="Cap&iacute;tulo <?= $next['nroCapitulo'] ?>" onclick="alert('Este capitulo no esta disponible.')" style="color:inherit;text-decoration:inherit;">
				<i style="font-size:64px;margin-top:10px;" class="fa fa-book"></i>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br>Pr&oacute;ximamente</h3>
				</a>
			</div>
			<?php
		}else{ //Si esta disponible
			?>
			<form method="post" action="../navigation/nav.php">
				<input type="hidden" name="target_page" value="/viewer.php"/>
				<input type="hidden" name="nroCapitulo" value="<?= $next['nroCapitulo'] ?>"/>
	      <input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

				<a title="Cap&iacute;tulo <?= $next['nroCapitulo'] ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
				<i style="font-size:64px;margin-top:10px;" class="fa fa-book"></i>
				<h3 class="title">Cap&iacute;tulo <?= $next['nroCapitulo'] ?><br> Disponible</h3>
				</a>
			</form>
			<?php
		}


	}//fin while de registros



?>
</div>

<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
      <input type="hidden" name="target_page" value="/pages/detalleCapitulo/listarCapitulos.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page + 1 ?> de <?=$cantPaginas?>. Capitulos totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
      <input type="hidden" name="target_page" value="/pages/detalleCapitulo/listarCapitulos.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  }

?>
</div>
<?php }else{
	echo "<h1>No se encontraron capitulos para este libro.</h1>";
}
?>
</div> </div>
