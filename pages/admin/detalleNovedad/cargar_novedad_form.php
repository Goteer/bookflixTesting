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
				<td>Resumen</td>
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
				<td>Foto</td>
				<td><input type="file" id="foto" name="uploadedImage"></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
			</tr>
			<tr>
				<td>Video</td>
				<td><input type="file" id="video" name="uploadedVideo"></td> <!-- name="uploadedVideo" para que lo reconozca class.uploadVideo.php -->
			</tr>
				<tr>
					<td>Descripcion</td>
					<td><textarea rows="10" cols="50" name="contenido" required><?php 
								if (isset($_SESSION['contenido'])){
									echo $_SESSION['contenido'];
								}
									else{
										echo '';
									}
									 ?></textarea></td>
				</tr>
				<td>&nbsp;</td>

				<td><input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/cargar_novedad.php"/>
        <a onclick="this.parentNode.submit();"><button>Ingresar novedad</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>
<?php
	$_SESSION['contenido'] = null;
	$_SESSION['titulo'] = null;
	$_SESSION['descripcion'] = null;

?>
