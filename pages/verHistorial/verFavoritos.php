<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<br>
<div style="margin-left:10px">
<form method="post" action="../navigation/nav.php" style="display:inline">
	<input type="hidden" name="target_page" value="/pages/home/home.php"/>
	<button class="boton" onclick="this.parentNode.submit();">Volver al home</button>
</form></div>
<br>

<h1 style="margin-left:10px;color:white">Libros Favoritos:</h1><br>

<div align="center">
  <div class="cuadro-listado">

<?php

$page = (isset($_POST['page']))?($_POST['page']):(0);

$queryCount = $conn->query("SELECT COUNT(*) from favoritos LEFT JOIN libros ON libros.idLibro = favoritos.idLibro WHERE libros.fechaPublicacion < current_timestamp() AND libros.fechaVencimiento > current_timestamp() AND (libros.pathFile != '/' OR porCapitulos = 1) AND idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_SESSION['profileId']."'");

$cantidadTotal = $queryCount->fetchColumn();

if ($cantidadTotal>0) {

$librosPorPagina = 9;
$cantPaginas = ceil($cantidadTotal/$librosPorPagina);


$libros = $conn->query("SELECT * from favoritos LEFT JOIN libros ON libros.idLibro = favoritos.idLibro WHERE libros.fechaPublicacion < current_timestamp() AND libros.fechaVencimiento > current_timestamp() AND (libros.pathFile != '/' OR porCapitulos = 1) AND idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_SESSION['profileId']."' ORDER BY favoritos.fechaAct ASC LIMIT ".$librosPorPagina." OFFSET ".($librosPorPagina*$page));



?>

<div class="favoritos" style="margin:0 30px;">
<?php
	while ($next = $libros->fetch()){
		if (strtotime($next['fechaVencimiento'])<time()){ //Si esta vencido
			?>
			<div>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
        <input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

        <a title="<?= $next['nombre'] ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
        <img src="<?= $next['foto'] ?>" alt="<?= $next['nombre'] ?>" onerror="this.src='../../pdf/img/default.png'"/>
        <h3 class="title">Vencido</h3>
        </a>

      </form>
			<form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="porCapitulos" value="<?=$next['porCapitulos']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/class/desmarcarFavorito.php"/>
        <input type="hidden" name="retorno" value="/pages/verHistorial/verFavoritos.php"/>
        <a onclick="this.parentNode.submit();"><h4>Quitar libro como favorito</h4></a>
      </form>
		</div>
			<?php
		}elseif (strtotime($next['fechaPublicacion'])>time()){ //Si no es publico aun
			?>
			<div>
      <form method="post" action="../navigation/nav.php">
  			<input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
  			<input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

  			<a title="<?= $next['nombre'] ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
  			<img src="<?= $next['foto'] ?>" alt="<?= $next['nombre'] ?>" onerror="this.src='../../pdf/img/default.png'"/>
  			<h3 class="title">Proximamente</h3>
  			</a>
  		</form>
			<form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="porCapitulos" value="<?=$next['porCapitulos']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/class/desmarcarFavorito.php"/>
        <input type="hidden" name="retorno" value="/pages/verHistorial/verFavoritos.php"/>
        <a onclick="this.parentNode.submit();"><h4>Quitar libro como favorito</h4></a>
      </form>
		</div>
			<?php
		}else{ //Si esta disponible
			?>
			<div>
      <form method="post" action="../navigation/nav.php">
  			<input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
  			<input type="hidden" name="bookID" value="<?= $next['idLibro'] ?>"/>

  			<a title="<?= $next['nombre'] ?>" onclick="this.parentNode.submit();" style="color:inherit;text-decoration:inherit;">
  			<img src="<?= $next['foto'] ?>" alt="<?= $next['nombre'] ?>" onerror="this.src='../../pdf/img/default.png'"/>
  			<h3 class="title"><?= $next['nombre'] ?></h3>
  			</a>
  		</form>
			<form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="porCapitulos" value="<?=$next['porCapitulos']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/class/desmarcarFavorito.php"/>
        <input type="hidden" name="retorno" value="/pages/verHistorial/verFavoritos.php"/>
        <a onclick="this.parentNode.submit();"><h4>Quitar libro como favorito</h4></a>
      </form>
		</div>
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
	echo "<h1>No se encontraron libros marcados como favoritos.</h1>";
}
?>
</div> </div>
