



<?php
include_once "../../resources/framework/class/class.novedad.php";
include "../../resources/framework/DBconfig.php";

if (isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 0;
}

$queryCant = $conn->query("SELECT COUNT(*) AS count FROM novedades");
$queryCant = $queryCant->fetch();
$cantidadTotal = $queryCant['count'];
$novedadesPorPagina = 10;
$cantPaginas = ceil($cantidadTotal/$novedadesPorPagina);


$novedades = new NovedadDB();
$novedades->setOtros("ORDER BY fecha DESC LIMIT ".$novedadesPorPagina." OFFSET ".$page*$novedadesPorPagina);
$novedades->fetchRecordSet($conn);
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
    <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/cargar_novedad_form.php"/>
    <a onclick="this.parentNode.submit();"><button>Cargar nueva novedad</button></a>
  </form>
</div>
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-2"> Titulo </div>
    <div class="col-md-2"> Resumen </div>
    <div class="col-md-3"> Foto </div>
		<div class="col-md-3"> Video </div>
    <div class="col-md-2"> Acciones </div>
  </h2>
  <br>
</div>
<?php
$hay = false;
while ($next = $novedades->getNextRecord()){
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
    <div class="col-md-2"> <h3><?= $next->titulo ?></h3> </div>
    <div class="col-md-2"> <?php if (strlen($next->descripcion)>140) {
              $next->descripcion = substr($next->descripcion,0,256)."(...)";
            } echo $next->descripcion; ?> </div>
    <div class="col-md-3"> <img onerror="this.src='../../resources/img/news-icon.png';" style="max-width:50%;" src="<?= $next->foto?>"/> </div>
		<div class="col-md-3" style="diplay: flex;">  <video style="width:75%;" controls> <source src="<?= $next->video?>" type="video/mp4"> Tu navegador no soporta video embebido en HTML</video>  </div>
    <div class="col-md-2">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="idNovedad" value="<?=$next->idNovedad?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/modificar.php"/>
        <a onclick="this.parentNode.submit();"><button>Editar novedad</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
				<input type="hidden" name="idNovedad" value="<?=$next->idNovedad?>"/>
				<input type="hidden" name="target_page" value="/pages/detalleNovedad/verNovedad.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver novedad</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="novedadID" value="<?=$next->idNovedad?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/eliminar_novedad.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar novedad</button></a>
      </form>
    </div>



  </div>
<?php
}
if (!$hay){
    echo "No hay novedades en la base de datos.";
  }
?>

<br>
<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page+ 1 ?> de <?=$cantPaginas?>. Novedades totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_novedad.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
</div>

</div>
</div>
