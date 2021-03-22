
<div align="center"> <div class="cuadro-listado">
<?php
$libro = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']);
$libro = $libro->fetch();


if ((!isset($_POST['fechaPublicacion']) || $_POST['fechaPublicacion'] == '') && (!isset($_POST['fechaVencimiento']) || $_POST['fechaVencimiento'] == '') ) {
  echo '<h1>No se ingreso ninguna fecha. No hay cambios</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
    <input type="hidden" name="bookId" value="'.$_POST['bookId'].'"/>
    <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
  </form>
  ';
  die();
}

if ((isset($_POST['fechaVencimiento']) && $_POST['fechaVencimiento'] != '') && (strtotime($_POST['fechaPublicacion'])>strtotime($_POST['fechaVencimiento']))){
  echo '<h1>Error: La fecha de vencimiento es anterior o igual a la fecha de publicacion.</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
    <input type="hidden" name="bookId" value="'.$_POST['bookId'].'"/>
    <input type="hidden" name="fechaPublicacion" value="'.$_POST['fechaPublicacion'].'"/>
    <input type="hidden" name="fechaVencimiento" value="'.$_POST['fechaVencimiento'].'"/>
    <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
  </form>
  ';
  die();
}



$fechaPublicacion = (isset($_POST['fechaPublicacion']))?$_POST['fechaPublicacion']:$next['fechaPublicacion'];
$fechaVencimiento = (isset($_POST['fechaVencimiento']))?$_POST['fechaVencimiento']:$next['fechaVencimiento'];




if (isset($_POST['nroCapitulo'])){

  if ($conn->exec("UPDATE capitulos SET fechaPublicacion = ".$conn->quote($fechaPublicacion).
    ", fechaVencimiento = ".$conn->quote($fechaVencimiento).
    " WHERE idLibro = ".$_POST['bookId']." AND nroCapitulo = ".$_POST['nroCapitulo']))
    {

    }else {
      echo '<h1>Error al modificar la/s fecha/s del capitulo.</h1><br>
      <form method="post">
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
        <input type="hidden" name="bookId" value="'.$_POST['bookId'].'"/>
        <input type="hidden" name="nroCapitulo" value="'.$_POST['nroCapitulo'].'"/>
        <input type="hidden" name="fechaPublicacion" value="'.$_POST['fechaPublicacion'].'"/>
        <input type="hidden" name="fechaVencimiento" value="'.$_POST['fechaVencimiento'].'"/>
        <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
      </form>
      ';
      die();
    }

}else{

  if ($conn->exec("UPDATE libros SET fechaPublicacion = ".$conn->quote($fechaPublicacion).
    ", fechaVencimiento = ".$conn->quote($fechaVencimiento).
    " WHERE idLibro = ".$_POST['bookId']))
    {

    }else {
      echo '<h1>Error al modificar la/s fecha/s del libro.</h1><br>
      <form method="post">
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
        <input type="hidden" name="bookId" value="'.$_POST['bookId'].'"/>
        <input type="hidden" name="fechaPublicacion" value="'.$_POST['fechaPublicacion'].'"/>
        <input type="hidden" name="fechaVencimiento" value="'.$_POST['fechaVencimiento'].'"/>
        <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
      </form>
      ';
      die();
    }
}




?>
<h1>Fecha/s modificada/s correctamente.</h1><br>
<?php
if (strtotime($_POST['fechaPublicacion'])>time() ) {
  //Si antes tenia fecha publicacion que paso y ahora es en el futuro y el nuevo vencimiento no lo oculta:
  echo "<h1>La fecha de publicacion es mas reciente que la actual, por lo que se ha ocultado el libro.</h1><br>";

}elseif(strtotime($_POST['fechaVencimiento'])<time()){
  //Fecha publicacion previa pero nuevo vencimiento es previo a la fecha actual
  echo "<h1>La fecha de vencimiento fijada es previa a la actual, por lo tanto el libro est&aacute; vencido y ser&aacute; ocultado.</h1><br>";
}

?>
<form method="post">
  <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
  <a onclick="this.parentNode.submit();"><button class="boton">Volver</button></a>
</form>
</div></div>
