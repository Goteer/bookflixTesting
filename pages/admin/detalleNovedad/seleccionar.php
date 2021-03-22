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


<?php

	function seleccionar($id){

		if (isset($id)){
			$consulta = new ConsultasNovedad();
			$filas = $consulta->verNovedad($id);

			foreach ($filas as $fila) {	?>
				
					<form name="formulario" action="../navigation/nav.php" method = "post" onsubmit="return validateForm()">
						<input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/modificar_novedad.php"/>
						<table>
							<tr>
								<td>Contenido</td>
								<td><textarea style="color: #000000" rows="10" cols="30" name="contenido" required><?php 
								if (isset($_SESSION['contenido'])){
									echo $_SESSION['contenido'];
								}
									else{
										echo $fila['contenido'];
									}
									 ?></textarea></td>
							</tr>
							<tr>
								<td>Foto</td>
								<td><td><input type="file" id="foto" name="uploadedImage"></td></td>
							</tr>
							<tr>
								<td>Video</td>
								<td><input type="file" id="video" name="uploadedVideo"></td>
							</tr>
							<tr>
								<td>Descripcion</td>
								<td><textarea style="color: #000000" rows="10" cols="30" name="descripcion" required><?php 
								if (isset($_SESSION['descripcion'])){
									echo $_SESSION['descripcion'];
								}
									else{
										echo $fila['descripcion'];
									}
									 ?></textarea></td>
							</tr>
							<tr>
								<td>Titulo</td>
								<td><input type="text" style="color: #000000" name="titulo" value="<?php 
								if (isset($_SESSION['titulo'])){
									echo $_SESSION['titulo'];
								}
									else{
										echo $fila['titulo'];
									}
									 ?>" required></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="hidden" name="id" value="<?=$id?>"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><a onclick="this.parentNode.submit();"><button>Modificar novedad</button></a></td></td>
							</tr>

						</table>


					</form>


<?php			
	$_SESSION['contenido'] = null;
	$_SESSION['titulo'] = null;
	$_SESSION['descripcion'] = null;	
			}
		}

	}

?>


