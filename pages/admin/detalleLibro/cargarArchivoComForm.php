<script>
function confirmar()
{
  var respuesta = confirm("Aviso: Este libro tiene capitulos cargados. Si se carga un archivo para libro entero se eliminarán todos los capitulos ya cargados y se marcará el libro como entero. ¿Continuar?");
  if (respuesta){ document.getElementById("datos").submit(); }
  return respuesta;
}
</script>
<style>
button {
  background-color: #555555;
  color: white;
  padding: 14px 20px;
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
  width:80%;
}

input, select, textarea{
    color: #000000;
}

.row {
  margin: 15px 0;
  border:1px;
  border-style: solid;
  border-color: white;
  background-color: rgba(0, 0, 0, 0.35);
}
.no-margin
{
  margin: 0px !important;
}

.datepicker {
  color: #000000;
}

.datepicker .disabled {
  color: #AAAAAA;
}

.datepicker-switch, .prev, .next, .day, .month {
  cursor: pointer;
}

</style>


<?php

$libroMarcadoPorCapitulos = $conn->query("SELECT porCapitulos from libros WHERE idLibro = ".$_POST['bookId']);
$libroMarcadoPorCapitulos = $libroMarcadoPorCapitulos->fetchColumn();
$cantCapitulos = $conn->query("SELECT COUNT(DISTINCT nroCapitulo) from capitulos WHERE idLibro = ".$_POST['bookId']);
$cantCapitulos = $cantCapitulos->fetchColumn();


if ($libroMarcadoPorCapitulos) {
  $estaCompletoQuery = $conn->query("SELECT MAX(capitulos.esCapituloFinal) FROM capitulos WHERE idLibro = ".$_POST['bookId']);
  $estaCompleto = ($estaCompletoQuery->fetchColumn() == 1);
}else{
  $estaCompletoQuery = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']);
  $estaCompletoQuery = $estaCompletoQuery->fetch();
  $estaCompleto = (isset($estaCompletoQuery['pathFile']) && $estaCompletoQuery['pathFile'] != '' && $estaCompletoQuery['pathFile'] != '/');
}

if ($estaCompleto){
    echo '<h1>Error: El libro ya esta completo.</h1><br>
    <form method="post">
      <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
      <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
    </form>
    ';
    die();
}


?>






<div align="center" width="100%">
<div class="cuadro-listado">
	<form id="datos" method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<table>
  			<tr>
  				<td>PDF</td>
  				<td><input type="file" id="pdf" name="uploadedPdf" required></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
  			</tr>
       		<tr>
  				<td>Fecha publicacion</td>
  				<td><input id="fechaPublicacionInput" type="text" name="fechaPublicacion" min="<?= date('Y-m-d') ?>" required value="<?= date('Y-m-d') ?>"></td>
  			</tr>
        	<tr>
  				<td>Fecha vencimiento</td>
  				<td><input id="fechaVencimientoInput" type="text" name="fechaVencimiento" min="<?= date('Y-m-d') ?>"></td>
  			</tr>
  			<tr>

				<td>&nbsp;</td>

				<td><input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoCom.php"/>
          <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
        <a <?= ($libroMarcadoPorCapitulos)?'onclick="confirmar();"':'onclick="this.parentNode.submit();"' ?>><button>Subir archivo</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>

<script>
$('#fechaPublicacionInput').datepicker({
    format: "yyyy-mm-dd",
    startDate: "Today",
    todayHighlight: true,
    language: "es"
});
$('#fechaVencimientoInput').datepicker({
    format: "yyyy-mm-dd",
    startDate: "Today",
    todayHighlight: true,
    language: "es"
});
</script>
