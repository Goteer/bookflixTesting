<script type="text/javascript">
  function confirmacionEliminar()
  {
    var respuesta = confirm("¿Estas seguro que deseas eliminar?");
    return respuesta;
  }

  function revelarReseña(num){
if (document.getElementById("contenido_"+num).style.filter == "blur(5px)"){
  document.getElementById("contenido_"+num).style.filter = "blur(0px)";
  document.getElementById("revelar_"+num).innerHTML = "Ocultar Spoiler";
}else{
  document.getElementById("contenido_"+num).style.filter = "blur(5px)";
  document.getElementById("revelar_"+num).innerHTML = "Revelar Spoiler";
}

}
</script>
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
$query = $conn->query("SELECT *,perfiles.nombre from resenas left join perfiles on perfiles.idPerfil = resenas.idPerfil WHERE idLibro = ".$_POST['bookId']." AND idLibro = '".$_POST['bookId']."' ORDER BY fechaAct DESC LIMIT ".$resenasPorPagina." OFFSET ".$page*$resenasPorPagina);
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
  <?php
  $queryPerfil=$conn->query("SELECT *,perfiles.nombre from resenas left join perfiles on perfiles.idPerfil = resenas.idPerfil WHERE resenas.idPerfil = ".$_SESSION['profileId']." AND idLibro = '".$_POST['bookId']."'");
  $perfilCoincide = $nombrePerfil=$queryPerfil->fetch();

  $leido = $conn->query("SELECT * FROM librosterminados WHERE idUsuario = '".$_SESSION['id']."' AND idPerfil = '".$_SESSION['profileId']."' AND idLibro = '".$_POST['bookId']."'");
  if (!$perfilCoincide && !$leido->fetch()){
    echo "<h3>No marcaste este libro como terminado, por lo que no ten&eacute;s permitido dejar una rese&ntilde;a.</h3>";
  }else{
    if (!$perfilCoincide){
    ?>
    <form method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
      <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/cargar_resena_form.php"/>
      <a onclick="this.parentNode.submit();"><button>Rese&ntilde;ar libro</button></a>
    </form>
    <?php
  }else{
    ?>
    <form method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
      <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/cargar_resena_form.php"/>
      <a><button type="button" style="background-color:#222;color:#444">Rese&ntilde;ar libro</button></a>
    </form>
    <?php
  }
  }
  ?>

</div>
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-2"> Perfil </div>
    <div class="col-md-3"> Fecha de publicación </div>
    <div class="col-md-2"> Contenido </div>
    <div class="col-md-3"> Puntaje </div>
    <div class="col-md-2"> Acciones </div>
  </h2>
  <br>
</div>
<?php



if ($perfilCoincide) {


?>

  <div class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-2"> <h3><?= $nombrePerfil['nombre'] ?></h3> </div>
    <div class="col-md-3"> <h3><?= $nombrePerfil['fechaAct']?></h3> </div>
    <div class="col-md-2"> <h3><?= $nombrePerfil['contenido'] ?></h3> </div>
    <div class="col-md-3"> <h3><?= $nombrePerfil['puntaje'] ?></h3> </div>
    <div class="col-md-2">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
        <input type="hidden" name="idResena" value="<?=$nombrePerfil['idResena']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/eliminarMiResena.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar rese&ntilde;a</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
        <input type="hidden" name="idResena" value="<?=$nombrePerfil['idResena']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/modificarResenaForm.php"/>
        <a onclick="this.parentNode.submit();"><button>Modificar rese&ntilde;a</button></a>
      </form>
      <a onclick="this.parentNode.submit();"><button disabled value>Reportar</button></a>  <!--esto lo puse para que no quede tan vacio la parte de acciones-->
    </div>
  </div>
<br><br><br><br>



<?php
}
$hay = false;
while ($next = $query->fetch()){
  $hay = true;
	/*<td>{$next->idNovedad}</td>
	<td>{$next->titulo}</td>
	<td>{$next->descripcion}</td>
	<td>{$next->foto}</td>
	<td>{$next->video}</td>*/
  if ($next['spoiler'] > 0) {

?>


  <div class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-2"> <h3><?php if($next['nombre'] != ''){echo $next['nombre'];}else{echo '[Perfil borrado]';} ?></h3> </div>
    <div class="col-md-3"> <h3><?= $next['fechaAct']?></h3> </div>
    <div class="col-md-2" id="contenido_<?=$next['idResena']?>" style="filter:blur(5px)"> <h3><?= $next['contenido'] ?></h3> </div>
		<div class="col-md-3"> <h3><?= $next['puntaje'] ?></h3> </div>
    <div class="col-md-2">
      <form method="post" action="../navigation/nav.php">
				<input type="hidden" name="idResena" value="<?=$next->idResena?>"/>
				<input type="hidden" name="target_page" value="/pages/Reportar.php"/>
        <a onclick="this.parentNode.submit();"><button disabled value>Reportar</button></a>  <!--esto lo puse para que no quede tan vacio la parte de acciones-->
      </form>
      <button type="button" onClick="revelarReseña(<?=$next['idResena']?>);" id="revelar_<?=$next['idResena']?>">Revelar spoiler</button>
    </div>
  </div>



<?php
} else {
?>

  <div class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-2"> <h3><?php if($next['nombre'] != ''){echo $next['nombre'];}else{echo '[Perfil borrado]';} ?></h3> </div>
    <div class="col-md-3"> <h3><?= $next['fechaAct']?></h3> </div>
    <div class="col-md-2"> <h3><?= $next['contenido'] ?></h3> </div>
    <div class="col-md-3"> <h3><?= $next['puntaje'] ?></h3> </div>
    <div class="col-md-2">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="idResena" value="<?=$next->idResena?>"/>
        <input type="hidden" name="target_page" value="/pages/Reportar.php"/>
        <a onclick="this.parentNode.submit();"><button disabled value>Reportar</button></a>  <!--esto lo puse para que no quede tan vacio la parte de acciones-->
      </form>
    </div>
  </div>



<?php
}} if (!$hay){
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
      <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResenas.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
</div>

</div>
</div>
