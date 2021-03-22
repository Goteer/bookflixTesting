<?php
include_once "../../resources/framework/class/class.trailer.php";

$trailers = new TrailerDB();
$trailers->setFiltro("idTrailer = '".$_POST['idTrailer']."'");
$trailers->setOtros("LIMIT 1");

$trailers->fetchRecordSet($conn);
$trailer = $trailers->getNextRecord();
$valores = $trailer->getValues();

include_once "../../resources/framework/class/class.libro.php";

$filas = null;
$tabla = "libros";
$id = $valores['idLibAsociado'];
$sql = "SELECT nombre from $tabla where idLibro = $id";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetch();

?>
<style>

#header {
  background-image: linear-gradient(to bottom,#111, #333);
  height:3vh;
}

#cuerpo{
  margin-left: 5vw;
  margin-right: 5vw;
  background-color: #333;
}
#trailer{
  margin-left: 3vw;
  margin-right: 3vw;
}

#footer{
  background-image: linear-gradient(to top,#111, #333);
  height:3vh;
}
</style>
<style>
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
<div id="trailer">
<br>

<?php if (isset($valores['video'])){
  echo '<div align="center" width="100%"><video style="max-height:50vh" width="50%" controls> <source src="'.$valores['video'].'" type="video/'.substr($valores['video'],-3).'"> Tu navegador no soporta video embebido en HTML</video></div><br><br>';
}?>



<?php if (isset($valores['pdf'])){ ?>
  <form style="display:inline;" method="post" action="../navigation/nav.php">
    <input type="hidden" name="trailerID" value="<?=$_POST['idTrailer']?>"/>
    <input type="hidden" name="target_page" value="/viewerTrailer.php"/>
    <a onclick="this.parentNode.submit();"><button>Leer pdf</button></a>
  </form >
<?php } ?>



<?php if (isset($valores['pdf']) or isset($valores['video'])){echo "<hr>";}?>

<h1 id="titulo" style="font-family:Franklin Gothic"><?= $valores['titulo']; ?></h1>
<h3><?= $valores['descripcion'];?></h3>
<h3>


<!-- Aqui se muestra un link al libro asociado si es que lo tiene. -->
<?php if (isset($result[0])){ ?>
  <form style="display:inline;" method="post" action="../navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$id?>"/>
    <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
    <a onclick="this.parentNode.submit();"><button>Libro asociado: <?php echo $result[0] ?></button></a>
  </form >
<?php } ?>



</h3>
<br>
</div>
<?php
if ($_SESSION['role'] == 'Admin')
  {
?>
    <div align="center" class="row" style="padding-top:10px;padding-bottom:10px;margin-left:10%;margin-right:10%">
    <div class="col-md-12">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="idTrailer" value="<?=$trailer->idTrailer?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/modificar.php"/>
        <a onclick="this.parentNode.submit();"><button>Editar trailer</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="trailerID" value="<?=$trailer->idTrailer?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/eliminar_trailer.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar trailer</button></a>
      </form>
      <form class="boton" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todos los trailers</button></a>
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
<div id="footer">&nbsp;</div>
</div>
