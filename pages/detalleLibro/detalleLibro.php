<?php

$conn->query("DROP TABLE IF EXISTS temp;");
$conn->query("CREATE TEMPORARY TABLE temp SELECT idLibro,AVG(puntaje) AS puntaje FROM resenas GROUP BY idLibro;");
$queryLibros = $conn->query("SELECT libros.*,temp.puntaje FROM libros LEFT JOIN temp ON libros.idLibro = temp.idLibro
WHERE libros.idLibro = ".$_POST['bookID']." LIMIT 1 ;");
$valores = $queryLibros->fetch();
$conn->query("DROP TEMPORARY TABLE temp;");

$queryAutores = $conn->query("SELECT nombre,apellido FROM autores where idAutor =" .$valores['idAutor']."");
$autores = $queryAutores->fetch();

$queryGeneros = $conn->query("SELECT genero FROM generos where idGenero =" .$valores['idGenero']."");
$genero = $queryGeneros->fetch();

$queryEditorial = $conn->query("SELECT nombre FROM editoriales where idEditorial =" .$valores['idEditorial']."");
$editorial = $queryEditorial->fetch();

?>
<style>

#libro{
  margin-left: 3vw;
  margin-right: 3vw;
}

#footer{
  background-image: linear-gradient(to top,#111, #333);
  height:3vh;
}

#header {
  background-image: linear-gradient(to bottom,#111, #333);
  height:3vh;
}

#cuerpo{
  margin-left: 5vw;
  margin-right: 5vw;
  background-color: #333;
}

#footer{
  background-image: linear-gradient(to top,#111, #333);
  height:3vh;
}

button {
  background-color: #555555;
  color: white;
  padding: 5px 10px;
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
}
.row {
  margin: 15px 0;
  border:1px;
  border-style: solid;
  border-color: white;
}
.no-margin
{
  margin: 0px !important;
}

</style>
<br>
<div id="cuerpo">
<div id="header">&nbsp;</div>
<div id="libro">


<br>

<h1 id="titulo" style="font-family:Franklin Gothic"><?= $valores['nombre']; ?></h1><br>
<br>
<h2 id="autor">Autor: <?php echo $autores[0].$autores[1]; ?></h2><br>
<br>
<h2 id="autor">Genero: <?php echo $genero[0]; ?></h2><br>
<br>
<h2 id="autor">Editorial: <?php echo $editorial[0]; ?></h2><br>
<br>
<h2 style="font-weight:bold;font-size:24px;font-color:gold;">Puntaje promedio: <?= (isset($valores['puntaje']))?substr($valores['puntaje'],0,3).' / 5':'Sin calcular'?></h2><br>

<?php if (isset($valores['foto'])){
  if ($valores['foto'] != ''){
?>

<div align="center" width="100%"><img style="font-family:Franklin Gothic;max-height:60vh" src="<?= $valores['foto']?>" alt=" "/> </div><br>

<?php }} ?>

<h3><?= $valores['descripcion'];?></h3>
<span style="line-height:0.7cm; font-size:20px;font-family:Georgia sans-serif"></span><br>
<hr>


<?php
  include_once "../../resources/framework/class/class.trailer.php";
  include "../../resources/framework/DBconfig.php";
  $trailer = new TrailerDB();
  $id = $valores['idLibro'];
  $trailer->setFiltro("idLibAsociado = $id");
  $trailer->fetchRecordSet($conn);

  while ($next = $trailer->getNextRecord()){ ?>

  <form style="display:inline;" method="post" action="../navigation/nav.php">
    <input type="hidden" name="idTrailer" value="<?=$next->idTrailer?>"/>
    <input type="hidden" name="target_page" value="/pages/detalleTrailer/ver_trailer.php"/>
    <a onclick="this.parentNode.submit();"><button>Trailer asociado: <?php echo $next->titulo ?></button></a>
  </form >

<?php } if ($_SESSION['role'] == 'Admin') { ?>

  <form method="post" action="../navigation/nav.php">
  <input type="hidden" name="bookId" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="porCapitulos" value="<?=$valores['porCapitulos']?>"/>
  <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/detalleResena/listarResena.php"/>
  <a onclick="this.parentNode.submit();"><button>Ver reseñas de libro</button></a>
</form>

<?php } else{ ?>

<form method="post" action="../navigation/nav.php">
  <input type="hidden" name="bookId" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="porCapitulos" value="<?=$valores['porCapitulos']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
  <a onclick="this.parentNode.submit();"><button>Ver reseñas de libro</button></a>
</form>

<?php }if ($valores['porCapitulos'] == false){ ?>
  <form method="post" action="../navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
    <input type="hidden" name="target_page" value="/viewer.php"/>
    <a onclick="this.parentNode.submit();"><button>Leer libro</button></a>
  </form>


<?php }else{ ?>
  <form method="post" action="../navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
    <input type="hidden" name="target_page" value="/pages/detalleCapitulo/listarCapitulos.php"/>
    <a onclick="this.parentNode.submit();"><button>Ver Lista de capitulos</button></a>
  </form>
<?php }

$esFavorito = $conn->query("SELECT * FROM favoritos WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_SESSION['profileId']."' AND idLibro = '".$_POST['bookID']."'");


?>

<form method="post" action="../navigation/nav.php">
  <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="porCapitulos" value="<?=$valores['porCapitulos']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/class/marcarLeido.php"/>
  <a onclick="this.parentNode.submit();"><button>Marcar libro como leido</button></a>
</form>
<?php
if (!$esFavorito->fetch()){
?>
<form method="post" action="../navigation/nav.php">
  <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="porCapitulos" value="<?=$valores['porCapitulos']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/class/marcarFavorito.php"/>
  <a onclick="this.parentNode.submit();"><button>Guardar libro como favorito</button></a>
</form>
<?php
}else{
?>
<form method="post" action="../navigation/nav.php">
  <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="porCapitulos" value="<?=$valores['porCapitulos']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/class/desmarcarFavorito.php"/>
  <a onclick="this.parentNode.submit();"><button>Quitar libro como favorito</button></a>
</form>
<?php
}

?>

</div>
<div id="footer">&nbsp;</div>
</div>






<?php
if ($_SESSION['role'] == 'Admin')
  {
?>
    <div align="center" class="row" style="padding-top:10px;padding-bottom:10px;margin-left:10%;margin-right:10%">
    <div class="col-md-12">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookID']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editar_libro_form.php"/>
        <a onclick="this.parentNode.submit();"><button>Editar libro</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookID']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/eliminar_libro.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar libro</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todos los libros</button></a>
      </form>
    </div>
  </div>


  <script type="text/javascript">
    function confirmacionEliminar()
    {
      var respuesta = confirm("¿Estas seguro que deseas eliminar?");
      return respuesta;
    }
  </script>

<?php
  ;}

?>
