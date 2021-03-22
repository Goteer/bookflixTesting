<?php
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.autor.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.genero.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.editorial.php";

$autores = new AutorDB();
$autores->fetchRecordSet($conn);

$generos = new GeneroDB();
$generos->fetchRecordSet($conn);

$editoriales = new EditorialDB();
$editoriales->fetchRecordSet($conn);

?>
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

<div align="center" width="100%">
<div class="cuadro-listado">
	<form method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<table>
  			<tr>
  				<td>Titulo</td>
          <td><input type="text" name="nombre" required value="<?=(isset($_SESSION['nombre']))?$_SESSION['nombre']:''?>"></td>
          <td><input type="hidden" name="nombreModif" value=""></td>
        </tr>
        <tr>
          <td>Descripcion</td>
          <td><textarea rows="3" cols="15" name="descripcion" required><?=(isset($_SESSION['descripcion']))?$_SESSION['descripcion']:''?></textarea></td>
        </tr>
        <tr>
          <td>ISBN</td>
          <td><input type="number" name="isbn" required value="<?=(isset($_SESSION['isbn']))?$_SESSION['isbn']:''?>"></td>
          <td><input type="hidden" name="isbnModif" value=""></td>
  			</tr>
  			<tr>
  			<tr>
  				<td>Foto</td>
  				<td><input type="file" id="foto" name="uploadedImage"></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
  			</tr>
        <tr>
  				<td>Genero</td>
          <td><select id="genero" name="idGenero" required>
            <option disabled selected value> -- Elige un genero -- </option>
            <?php
              while ($nextGen = $generos->getNextRecord()){
                echo "<option ".(($nextGen->idGenero == $_SESSION['idGenero'])?'selected':'' )." value=".$nextGen->idGenero.">".$nextGen->genero."</option>";
              }
            ?>
          </select></td>
        </tr>
        <tr>
          <td>Editorial</td>
          <td><select id="editorial" name="idEditorial" required>
            <option disabled selected value> -- Elige un editorial -- </option>
            <?php
              while ($nextEdi = $editoriales->getNextRecord()){
                echo "<option ".(($nextEdi->idEditorial == $_SESSION['idEditorial'])?'selected':'' )." value=".$nextEdi->idEditorial.">".$nextEdi->nombre."</option>";
              }
            ?>
          </select></td>
        </tr>
        <tr>
          <td>Autor</td>
          <td><select id="autor" name="idAutor" required>
            <option disabled selected value> -- Elige un autor -- </option>
            <?php
              while ($nextAutor = $autores->getNextRecord()){
                echo "<option ".(($nextAutor->idAutor == $_SESSION['idAutor'])?'selected':'' )." value=".$nextAutor->idAutor.">".$nextAutor->nombre." ".$nextAutor->apellido."</option>";
              }
            ?>
          </select></td>
  			</tr>
				<td>&nbsp;</td>
        <?php
          $_SESSION['isbn'] = null;
          $_SESSION['nombre'] = null;
          $_SESSION['descripcion'] = null;
          $_SESSION['idAutor'] = null;
          $_SESSION['idEditorial'] = null;
          $_SESSION['idGenero'] = null;
        ?>

        <input type="hidden" name="bookId" value="<?=$_POST["bookId"]?>"/>
				<td><input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargar_libro.php"/>
        <a onclick="this.parentNode.submit();"><button>Ingresar libro</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>
