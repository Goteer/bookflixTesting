<?php
	include "../../resources/framework/DBconfig.php";
	include_once "../../resources/framework/class/class.libro.php";

	$filas = null;
	$tabla = "libros";
	$sql = "SELECT idLibro,nombre from $tabla";
	$statement = $conn->prepare($sql);
	$statement->execute();


?>

<head>
  <script src="/js/jquery-3.5.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

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

input, select, textarea, option, select{
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

</style>

<div align="center" width="100%">
<div class="cuadro-listado">
	<form method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<table>
			<tr>
				<td>Titulo</td>
				<td><input type="text" name="titulo" value="<?php 
								if (isset($_SESSION['titulo'])){
									echo $_SESSION['titulo'];
								}
									else{
										echo '';
									}
									 ?>" required></td>
			</tr>
			<tr>
				<td>Descripcion</td>
				<td><textarea rows="3" cols="15" name="descripcion" required><?php 
								if (isset($_SESSION['descripcion'])){
									echo $_SESSION['descripcion'];
								}
									else{
										echo '';
									}
									 ?></textarea></td>
			</tr>
			<tr>
			<tr>
				<td>Video</td>
				<td><input type="file" id="video" name="uploadedVideo"></td> <!-- name="uploadedVideo" para que lo reconozca class.uploadVideo.php -->
			</tr>
			<tr>
				<td>PDF</td>
				<td><input type="file" id="pdf" name="uploadedPdf"></td>
			</tr>
			<tr>
				<td>Libro asociado</td>
				<td>
					<select id="controBusqueda" name = "idLib" style="width: 80%">
						<option disabled selected value> -- Elige un libro -- </option>
						<?php while ($result = $statement->fetch()){ ?>
						<option value = "<?php echo $result[0] ?>">
							<?php echo $result[1] ?>
						</option>
						<?php } ?>
					</select>
				</td>
			</tr>
				<td>&nbsp;</td>

				<td><input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/cargarTrailer.php"/>
        <a onclick="this.parentNode.submit();"><button>Ingresar Trailer</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#controBusqueda').select2();
	})
</script>

<?php
	$_SESSION['titulo'] = null;
	$_SESSION['descripcion'] = null;

?>