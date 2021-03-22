<form method="POST" id="volver" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>
<form method="POST" id="error" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/cambiarNombreSuscriptor.php"/>
  <input type="hidden" name="nombre" value="<?=$_POST['nombre']?>"/>
  <input type="hidden" name="apellido" value="<?=$_POST['apellido']?>"/>
</form>
<br>
<div align="center">
<div id="content-box" style="width:80vw;">
<h2>
<?php

if  ( (isset($_POST['nombre']) and $_POST['nombre'] != '') or (isset($_POST['apellido']) and $_POST['apellido'] != '') ){

$query = "UPDATE users SET ";

if  ( (isset($_POST['nombre']) and $_POST['nombre'] != '') and (isset($_POST['apellido']) and $_POST['apellido'] != '') ){

$query .="nombre = ".$conn->quote($_POST['nombre'])." , "."apellido = ".$conn->quote($_POST['apellido'])." ";

}else{

if (isset($_POST['nombre']) and $_POST['nombre'] != ''){
    $query .="nombre = ".$conn->quote($_POST['nombre'])." ";

}else if (isset($_POST['apellido']) and $_POST['apellido'] != ''){
    $query .="apellido = ".$conn->quote($_POST['apellido'])." " ;
}

}

$query .= "WHERE id = ".$_SESSION['id'];

if ($conn->query($query)){
  echo "Cambios realizados con exito.";
  echo "<script>setTimeout(function(){document.forms['volver'].submit()},2000);</script>";
}else{
  echo "Hubo un error al realizar los cambios. Intente nuevamente mas tarde.";
  echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
}

}else{
  echo "No se ingresaron datos.";
  echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
}


?>
</h2>
</div>
</div>
