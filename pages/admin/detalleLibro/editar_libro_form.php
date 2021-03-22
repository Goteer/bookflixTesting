<?php
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.autor.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.genero.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.editorial.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.libro.php";

$autores = new AutorDB();
$autores->fetchRecordSet($conn);

$generos = new GeneroDB();
$generos->fetchRecordSet($conn);

$editoriales = new EditorialDB();
$editoriales->fetchRecordSet($conn);

$libros = new LibroDB();
$libros->setFiltro("idLibro = ".$_POST['bookId']);
$libros->fetchRecordSet($conn);
$libro = $libros->getNextRecord();

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
  				<td>Cambiar Titulo</td>
          <td><input type="text" name="nombre" value="<?php
                if (isset($_SESSION['nombre'])){
                  echo $_SESSION['nombre'];
                }
                  else{
                    echo $libro->nombre;
                  }
                   ?>" required></td>
          <td><input type="hidden" name="nombreModif" value="<?= $libro->nombre ?>"></td>
        </tr>
        <tr>
          <td>Cambiar Descripcion</td>
          <td><textarea rows="3" cols="15" name="descripcion"  required><?php
                if (isset($_SESSION['descripcion'])){
                  echo $_SESSION['descripcion'];
                }
                  else{
                    echo $libro->descripcion;
                  }
                   ?></textarea></td>
        </tr>
        <tr>
          <td>Cambiar ISBN</td>
          <td><input type="number" name="isbn" value="<?php
                if (isset($_SESSION['isbn'])){
                  echo $_SESSION['isbn'];
                }
                  else{
                    echo $libro->isbn;
                  }
                   ?>" required></td>
          <td><input type="hidden" name="isbnModif" value="<?= $libro->isbn ?>"></td>
  			</tr>
  			<tr>
  			<tr>
  				<td>Cambiar Foto</td>
  				<td><input type="file" id="foto" name="uploadedImage"></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
  			</tr>
        <tr>
  				<td>Cambiar Genero</td>
  				<td><select id="genero" name="idGenero">
            <?php
              while ($nextGen = $generos->getNextRecord()){
                echo "<option ". ( ($nextGen->idGenero == $libro->idGenero)?'selected ':'' ) ."value=".$nextGen->idGenero.">".$nextGen->genero."</option>";
              }
            ?>
          </select></td>
  			</tr>
        <tr>
  				<td>Cambiar Editorial</td>
          <td><select id="editorial" name="idEditorial">
            <?php
              while ($nextEdi = $editoriales->getNextRecord()){
                echo "<option ". ( ($nextEdi->idEditorial == $libro->idEditorial)?'selected ':'' ) ."value=".$nextEdi->idEditorial.">".$nextEdi->nombre."</option>";
              }
            ?>
          </select></td>
  			</tr>
        <tr>
  				<td>Cambiar Autor</td>
          <td><select id="autor"  name="idAutor">
            <?php
              while ($nextAutor = $autores->getNextRecord()){
                echo "<option ". ( ($nextAutor->idAutor == $libro->idAutor)?'selected ':'' ) ."value=".$nextAutor->idAutor.">".$nextAutor->nombre." ".$nextAutor->apellido."</option>";
              }
            ?>
          </select></td>
  			</tr>
				<td>&nbsp;</td>

				<td><input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargar_libro.php"/>
          <input type="hidden" name="bookId" value="<?= $libro->idLibro ?>"/>
          <input type="hidden" name="action" value="modificar"/>
        <a onclick="this.parentNode.submit();"><button>Modificar libro</button></a></td>
				</tr>
		</table>
	</form>
</div>
</div>
<?php
  $_SESSION['isbn'] = null;
  $_SESSION['nombre'] = null;
  $_SESSION['descripcion'] = null;
?>

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
