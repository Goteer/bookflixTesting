<?php
include_once "../../resources/framework/class/class.novedad.php";

$novedades = new NovedadDB();
$novedades->setFiltro("idNovedad = '".$_POST['idNovedad']."'");
$novedades->setOtros("LIMIT 1");

$novedades->fetchRecordSet($conn);
$novedad = $novedades->getNextRecord();
$valores = $novedad->getValues();
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
#novedad{
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
<div id="novedad">
<?php if ($_SESSION['role'] == 'admin'){ echo "<h2>Ingresado como admin</h2>";}?>
<div align="center" width="100%"><img style="font-family:Franklin Gothic;max-height:60vh" src="<?= $valores['foto']?>" alt=" "  /> </div><br>

<?php if (isset($valores['video'])){
  echo '<div align="center" width="100%"><video style="max-height:50vh" width="50%" controls> <source src="'.$valores['video'].'" type="video/'.substr($valores['video'],-3).'"> Tu navegador no soporta video embebido en HTML</video></div><br><br>';
}?>

<?php if (isset($valores['foto']) or isset($valores['video'])){echo "<hr>";}?>

<h1 id="titulo" style="font-family:Franklin Gothic"><?= $valores['titulo']; ?></h1>
<h3><?= $valores['descripcion'];?></h3>
<br>
<span style="line-height:0.7cm; font-size:20px;font-family:Georgia sans-serif"><?= $valores['contenido'];?></span>
</div>
<div id="footer">&nbsp;</div>
<div align="center" class="row no-margin" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-12">
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="idNovedad" value="<?=$next->idNovedad?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/modificar.php"/>
        <a onclick="this.parentNode.submit();"><button>Editar novedad</button></a>
      </form>
      <form method="post" action="../navigation/nav.php">
        <input type="hidden" name="novedadID" value="<?=$next->idNovedad?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/eliminar_novedad.php"/>
        <a onclick="return confirmacionEliminar();this.parentNode.submit();"><button>Eliminar novedad</button></a>
      </form>
      <form class="boton" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_Novedad.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todas las novedades</button></a>
      </form>
    </div>
  </div>
</div>
