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

$libro = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']);
$libro = $libro->fetch();
$libroMarcadoPorCapitulos = isset($_POST['operacion']);
$capitulos = $conn->query("SELECT * from capitulos WHERE idLibro = ".$_POST['bookId']);
$capituloMarcado = (isset($_POST['nroCapitulo']))?$_POST['nroCapitulo']:0;

?>






<div align="center" width="100%">
<div class="cuadro-listado">
	<form id="datos" method="POST" enctype="multipart/form-data" action="../../pages/navigation/nav.php">
		<table>
      <?php
      if ($libroMarcadoPorCapitulos){

      ?>
      <tr>
      <td>Capitulo al que cambiar la/s fecha/s </td>
      <td><select name="nroCapitulo" onchange="fechasValue(this.value)">
        <?php while ($next = $capitulos->fetch()){
          echo "<option ".(($capituloMarcado == $next['nroCapitulo'])?'selected':'')." id='cap".$next['nroCapitulo']."' fechaPublicacion='".$next['fechaPublicacion']."' fechaVencimiento='".$next['fechaVencimiento']."' value='".$next['nroCapitulo']."'>Capitulo ".$next['nroCapitulo']."</option>";
        }?>
      </select></td>
      </tr>
      <tr>
      <td>Fecha publicacion</td>
      <td><input id="fechaPublicacionInput" type="text" name="fechaPublicacion" placeholder=""  value="<?= (isset($_POST['fechaPublicacion']))?$_POST['fechaPublicacion']:'' ?>"></td>
    </tr>
      <tr>
      <td>Fecha vencimiento</td>
      <td><input id="fechaVencimientoInput" type="text" name="fechaVencimiento" placeholder="" value="<?= (isset($_POST['fechaVencimiento']))?$_POST['fechaVencimiento']:'' ?>"></td>
    </tr>
    <tr>
    <?php }else{?>
       		<tr>
  				<td>Fecha publicacion</td>
  				<td><input id="fechaPublicacionInput" type="text" name="fechaPublicacion" value="<?= (isset($_POST['fechaPublicacion']))?$_POST['fechaPublicacion']:substr($libro['fechaPublicacion'],0,10) ?>"></td>
  			</tr>
        	<tr>
  				<td>Fecha vencimiento</td>
  				<td><input id="fechaVencimientoInput" type="text" name="fechaVencimiento" value="<?= (isset($_POST['fechaVencimiento']))?$_POST['fechaVencimiento']:substr($libro['fechaVencimiento'],0,10) ?>"></td>
  			</tr>
  			<tr>
<?php } ?>
				<td>&nbsp;</td>

				<td><input type="hidden" name="target_page" value="/pages/admin/detalleLibro/class.cambiarFechas.php"/>
          <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
        <a onclick="this.parentNode.submit();"><button>Cambiar fechas</button></a></td>
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
    todayHighlight: true,
    language: "es"
});
$('#fechaVencimientoInput').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    language: "es"
});


function fechasValue(value){
  var optionId = "cap"+value;
  $("#fechaPublicacionInput").val( $("#"+optionId).attr("fechaPublicacion").substring(0,10) );
  $("#fechaVencimientoInput").val( $("#"+optionId).attr("fechaVencimiento").substring(0,10) );
}

fechasValue(1);

</script>
