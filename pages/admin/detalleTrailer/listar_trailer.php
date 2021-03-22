



<?php
include_once "../../resources/framework/class/class.trailer.php";
include "../../resources/framework/DBconfig.php";

if (isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 0;
}

$queryCant = $conn->query("SELECT COUNT(*) AS count FROM trailers");
$queryCant = $queryCant->fetch();
$cantidadTotal = $queryCant['count'];
$trailersPorPagina = 10;
$cantPaginas = ceil($cantidadTotal/$trailersPorPagina);


$trailer = new TrailerDB();
$trailer->setOtros("ORDER BY fecha DESC LIMIT ".$trailersPorPagina." OFFSET ".$page*$trailersPorPagina);
$trailer->fetchRecordSet($conn);
?>

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
<BR>
<div align="center">
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
  <form method="post" action="../navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$next->idLibro?>"/>
    <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/cargarTrailerForm.php"/>
    <a onclick="this.parentNode.submit();"><button>Cargar nuevo Trailer</button></a>
  </form>
</div>
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-3"> Titulo </div>
    <div class="col-md-3"> Descripcion </div>
		<div class="col-md-3"> Video </div>
    <div class="col-md-3"> Acciones </div>
  </h2>
  <br>
</div>
<?php
$hay = false;
while ($next = $trailer->getNextRecord()){
  $hay = true;
	/*<td>{$next->idNovedad}</td>
	<td>{$next->titulo}</td>
	<td>{$next->descripcion}</td>
	<td>{$next->foto}</td>
	<td>{$next->video}</td>*/
  
?>
<script type="text/javascript">
    function confirmacionEliminar()
    {
      var respuesta = confirm("¿Estas seguro que deseas eliminar?");
      return respuesta;
    }
  </script>


  <div class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-3"> <h3><?= $next->titulo ?></h3> </div>
    <div class="col-md-3"> <?php if (strlen($next->descripcion)>140) {
              $next->descripcion = substr($next->descripcion,0,256)."(...)";
            } echo $next->descripcion; ?> </div>
		<div class="col-md-3" style="diplay: flex;">  <video style="width:75%;" controls> <source src="<?= $next->video?>" type="video/mp4"> Tu navegador no soporta video embebido en HTML</video>  </div>
    <div class="col-md-3">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="idTrailer" value="<?=$next->idTrailer?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/modificar.php"/>
        <a onclick="this.parentNode.submit();"><button>Editar Trailer</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
				<input type="hidden" name="idTrailer" value="<?=$next->idTrailer?>"/>
				<input type="hidden" name="target_page" value="/pages/detalleTrailer/ver_trailer.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver Trailer</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="trailerID" value="<?=$next->idTrailer?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/eliminar_Trailer.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar trailer</button></a>
      </form>
    </div>



  </div>
<?php
}
if (!$hay){
    echo "No hay Trailers en la base de datos.";
  }
?>

<br>
<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page+ 1 ?> de <?=$cantPaginas?>. Trailers totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
</div>

</div>
</div>
