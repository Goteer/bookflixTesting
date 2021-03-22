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
$libroTienePdf = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']." AND pathFile IS NOT NULL AND pathFile != '' AND pathfile != '/'");
$cantCapitulos = $conn->query("SELECT COUNT(DISTINCT nroCapitulo) from capitulos WHERE idLibro = ".$_POST['bookId']);
$cantCapitulos = $cantCapitulos->fetchColumn();

if (!$libroMarcadoPorCapitulos && $libroTienePdf->fetch()){ //Si el libro no esta marcado por capitulos y tiene un pdf asociado al libro entero
  echo '<div align="center"><div class="cuadro-listado"><h1>Error, este es un libro entero ya cargado. No se puede cargar capitulo.</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver a Libros</button></a>
  </form></div></div>
  ';
  die();
}

$tieneCapituloFinal = $conn->query("SELECT MAX(esCapituloFinal) FROM capitulos WHERE idLibro = ".$_POST['bookId']);

if ($tieneCapituloFinal->fetchColumn() && $tieneCapituloFinal){ //Si el libro no esta marcado por capitulos y tiene un pdf asociado al libro entero
  echo '<div align="center"><div class="cuadro-listado"><h1>Error, este libro ya est&aacute; terminado: Tiene un capitulo final. No se puede cargar un capitulo.</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver a Libros</button></a>
  </form></div></div>
  ';
  die();
}

?>

<div align="center" width="100%">
<div class="cuadro-listado">
	<form method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<table>
			<tr>
        <td>Numero de Capitulo</td>
          <td><input type="text" name="nroCapitulo" required value="<?= (isset($_POST['nroCapitulo']))?$_POST['nroCapitulo']:($cantCapitulos + 1)?>" placeholder="<?=($cantCapitulos + 1)?>"></td>
        </tr>
        <tr>
  				<td>PDF</td>
  				<td><input type="file" id="pdf" required name="uploadedPdf" ></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
  			</tr>
        <tr>
        <td>Fecha publicacion</td>
        <td><input id="fechaPublicacion" required type="text" name="fechaPublicacion" placeholder=""  value="<?= (isset($_POST['fechaPublicacion']))?$_POST['fechaPublicacion']:date("Y-m-d") ?>"></td>
      </tr>
        <tr>
        <td>Fecha vencimiento</td>
        <td><input id="fechaVencimiento" type="text" name="fechaVencimiento" placeholder="" value="<?= (isset($_POST['fechaVencimiento']))?$_POST['fechaVencimiento']:'' ?>"></td>
      </tr>
      <tr>
        <label>
        <input type="checkbox" value="1" name="capFinal" <?=(isset($_POST['capFinal']))?(($_POST['capFinal'] == 1)?'checked':''):''?> >
        Capitulo Final
        </label>
      </tr>
  			<tr>

				<td>&nbsp;</td>
        <input type="hidden" name="bookId" value="<?= $_POST['bookId']?>"/>
				<td><input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoCap.php"/>
        <a onclick="this.parentNode.submit();"><button>Subir capitulo</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>

<script>
$(document).ready(function(){

    $("#fechaPublicacion").datepicker({
        todayBtn:  1,
        format: "yyyy-mm-dd",
        autoclose: true,
        startDate: "Today"
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#fechaVencimiento').datepicker('setStartDate', minDate);
    });

    $("#fechaVencimiento").datepicker({
      format: "yyyy-mm-dd"
    })
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#fechaPublicacion').datepicker('setEndDate', minDate);
        });

});
</script>
