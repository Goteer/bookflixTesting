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

<br>
<div style="margin-left:10px">
<form method="post" action="../navigation/nav.php" style="display:inline">
	<input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
	<input type="hidden" name="bookId" value="<?= $_POST['bookId'] ?>"/>
	<button class="boton" onclick="this.parentNode.submit();">Volver al listado de capitulos</button>
</form></div>
<?php




$capitulo = $conn->query("SELECT * FROM capitulos WHERE idLibro = '".$_POST['bookId']."' AND nroCapitulo = '".$_POST['nroCapitulo']."'");
$capitulo = $capitulo->fetch();

if ($capitulo['esCapituloFinal'] == 1){
  $tieneCapituloFinal = 1;
}else{
  $tieneCapituloFinal = $conn->query("SELECT MAX(esCapituloFinal) FROM capitulos WHERE idLibro = ".$_POST['bookId']);
  $tieneCapituloFinal = $tieneCapituloFinal->fetchColumn();
}

?>


<div align="center">
<div id="content-box" style="width:50vw;">

<h2>Editar capitulo <?=$_POST['nroCapitulo']?></h2>
<?php
if ($tieneCapituloFinal == 1){
    echo '<h4>Aviso, Este libro ya est&aacute; finalizado: No podr&aacute; cambiar las fechas de publicacion o vencimiento por capitulo, ya que ahora corresponden las fechas para el libro entero.
    <br>Modifique las fechas del propio libro, o desmarque el capitulo final para que el libro quede incompleto.</h4><br>';
}
?>
<form method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
  <table>
    <tr>
        <td>Numero de Capitulo</td>
          <td><input type="text" name="newNroCapitulo" required value="<?= (isset($_POST['newNroCapitulo']))?$_POST['newNroCapitulo']:$_POST['nroCapitulo']?>" placeholder="<?=$_POST['nroCapitulo']?>"></td>
        </tr>
        <tr>
  				<td>PDF</td>
  				<td><input type="file" id="pdf" name="uploadedPdf" ></td> <!-- name="uploadedImage" para que lo reconozca class.uploadImage.php -->
  			</tr>
        <tr>
        <td>Fecha publicacion</td>
        <td><input <?=($tieneCapituloFinal == 1)?'disabled':''?> id="fechaPublicacionInput" type="text" name="fechaPublicacion" placeholder=""  value="<?= (isset($_POST['fechaPublicacion']))?$_POST['fechaPublicacion']:$capitulo['fechaPublicacion'] ?>"></td>
      </tr>
        <tr>
        <td>Fecha vencimiento</td>
        <td><input <?=($tieneCapituloFinal == 1)?'disabled':''?> id="fechaVencimientoInput" type="text" name="fechaVencimiento" placeholder="" value="<?= (isset($_POST['fechaVencimiento']))?$_POST['fechaVencimiento']:$capitulo['fechaVencimiento'] ?>"></td>
      </tr>
      <tr>
        <label>
        <input type="checkbox" <?=($tieneCapituloFinal == 1 && $capitulo['esCapituloFinal'] != 1)?'disabled':''?> value="1" name="capFinal" <?=(isset($_POST['capFinal']))?(($_POST['capFinal'] == 1)?'checked':''):(($capitulo['esCapituloFinal'] == 1)?'checked':'')?> >
        Capitulo Final
        </label>
      </tr>
    <tr>

      <td>&nbsp;</td>
      <?php
      if ($tieneCapituloFinal == 1) {
        echo '<input type="hidden" name="fechaPublicacion" value="'.$capitulo['fechaPublicacion'].'"/>';
        echo '<input type="hidden" name="fechaVencimiento" value="'.$capitulo['fechaVencimiento'].'"/>';

      }
      ?>
      <input type="hidden" name="bookId" value="<?= $_POST['bookId']?>"/>
      <input type="hidden" name="nroCapitulo" value="<?= $_POST['nroCapitulo']?>"/>
      <input type="hidden" name="tieneFinal" value="<?= $tieneCapituloFinal?>"/>
      <td><input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/class.editarCapitulo.php"/>
      <a onclick="this.parentNode.submit();"><button class="botonLeer">Editar capitulo</button></a></td>
      </tr>
  </table>
</form>

<form method="post" enctype="multipart/form-data" id="borrar<?=$_POST['bookId']?>" action="../navigation/nav.php">
  <input type="hidden" name="nroCapitulo" value="<?= $_POST['nroCapitulo']?>"/>
  <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
  <input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/eliminar_capitulo.php"/>
</form>
<a onclick="confirmacionEliminar(<?=$_POST['bookId']?>);"><button class="botonLeer">Eliminar capitulo</button></a>

</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>

<script>
$(document).ready(function(){

    $("#fechaPublicacionInput").datepicker({
        todayBtn:  1,
        format: "yyyy-mm-dd 00:00:00",
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#fechaVencimientoInput').datepicker('setStartDate', minDate);
    });

    $("#fechaVencimientoInput").datepicker({
      format: "yyyy-mm-dd 00:00:00"
    })
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#fechaPublicacionInput').datepicker('setEndDate', minDate);
        });

});


function confirmacionEliminar(formNumber)
    {
      form = document.getElementById("borrar"+formNumber);
      var respuesta = confirm("¿Estas seguro que deseas eliminar el Capitulo?");
      if (respuesta == true){
        form.submit();
      }
    }
</script>
