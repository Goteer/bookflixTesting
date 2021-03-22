<?php
include_once "../../resources/framework/class/class.resena.php";

if (isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 0;
}

$queryCant = $conn->query("SELECT COUNT(*) AS count FROM resenas WHERE idLibro = '".$_POST['bookId']."'");
$queryCant = $queryCant->fetch();
$cantidadTotal = $queryCant['count'];
$resenasPorPagina = 10;
$cantPaginas = ceil($cantidadTotal/$resenasPorPagina);


//$resenas->setOtros("ORDER BY fecha DESC LIMIT ".$resenasPorPagina." OFFSET ".$page*$resenasPorPagina);
$query = $conn->query("SELECT *,perfiles.nombre from resenas left join perfiles on perfiles.idPerfil = resenas.idPerfil WHERE idLibro = ".$_POST['bookId']." ORDER BY fechaAct DESC LIMIT ".$resenasPorPagina." OFFSET ".$page*$resenasPorPagina);
//$resenas->fetchRecordSet($conn);
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
  <form style="margin-left:10px;" method="post" name="volverForm" action="../navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$_POST['bookId']?>"/>
    <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
    <button>Volver al libro</button>
  </form>
<br>
<div align="center">
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-2"> Perfil </div>
    <div class="col-md-2"> Fecha de publicación </div>
    <div class="col-md-2"> Contenido </div>
    <div class="col-md-2"> Spoiler </div>
    <div class="col-md-2"> Puntaje </div>
    <div class="col-md-2"> Acciones </div>
  </h2>
  <br>
</div>
<?php
$hay = false;
while ($next = $query->fetch()){
  $hay = true;
	/*<td>{$next->idNovedad}</td>
	<td>{$next->titulo}</td>
	<td>{$next->descripcion}</td>
	<td>{$next->foto}</td>
	<td>{$next->video}</td>*/
?>


  <div class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-2"> <h3><?= (isset($next['nombre']) && $next['nombre'] != '')?$next['nombre']:'Perfil borrado' ?></h3> </div>
    <div class="col-md-2"> <h3><?= $next['fechaAct']?></h3> </div>
    <div class="col-md-2"> <h3><?= $next['contenido'] ?></h3> </div>
    <div class="col-md-2"> <h3><?= ($next['spoiler'] > 0)?(($next['spoiler']==2)?'Si,por Admin':'Si'):'No' ?></h3> </div>
    <div class="col-md-2"> <h3><?= $next['puntaje'] ?></h3> </div>
    <div class="col-md-2">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
				<input type="hidden" name="idResena" value="<?=$next['idResena']?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleLibro/detalleResena/eliminarResena.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar rese&ntilde;a</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
        <input type="hidden" name="idResena" value="<?=$next['idResena']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/detalleResena/marcarSpoiler.php"/>
        <a <?= ($next['spoiler'] == 2)?'':'onclick="this.parentNode.submit();"' ?>><button <?= ($next['spoiler'] == 2)?'style="background-color:#222;color:#333"':'' ?> type="button">Marcar como spoiler</button></a>
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
}
if (!$hay){
    echo "No hay reseñas para este libro.";
  }
?>

<br>
<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResenas.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page+ 1 ?> de <?=$cantPaginas?>. Rese&ntilde;as totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/detalleResena/listarResenas.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
</div>

</div>
</div>
