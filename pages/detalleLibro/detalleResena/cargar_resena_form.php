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
/*$libroMarcadoPorCapitulos = $conn->query("SELECT porCapitulos from libros WHERE idLibro = ".$_POST['bookId']);
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
*/
?>
<div align="center" width="100%">
<div class="cuadro-listado">
	<form method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
		<table>
  			<tr>
  				<td>Contenido</td>
  				<td><textarea rows="5" cols="30" name="contenido" required></textarea></td>
        	<tr>
  				<td>Puntaje</td>
  				<td><select id="puntaje" name="puntaje" required>
	            <option disabled selected value> -- Elige un puntaje -- </option>
	            <option>1</option>
	            <option>2</option>
	            <option>3</option>
	            <option>4</option>
	            <option>5</option>
	            </select></td>
  			</tr>
  			<tr>
  				<label>
    			<input type="checkbox" value="" name="spoiler">
    			Spoiler
  				</label>
  			</tr>
  			<tr>

				<td>&nbsp;</td>
				<td><input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/cargar_resena.php"/></td>
				<td><input type="hidden" name="nombrePerfil" value=""/> <!--Aca quiero poner el nombre de perfil, pero no estoy seguro como se hace -->
        <a onclick="this.parentNode.submit();"><button>Subir rese&ntilde;a</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>
