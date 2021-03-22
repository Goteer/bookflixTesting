<form method="POST" id="volver" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>
<form method="POST" id="error" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/cambiarEmail.php"/>
  <input type="hidden" name="email" value="<?=$_POST['email']?>"/>
</form>
<br>
<div align="center">
<div id="content-box" style="width:80vw;">
<h2>
<?php

if  ( (isset($_POST['email']) and $_POST['email'] != '')) {

$user = '';
if ( ($user = $conn->query("SELECT * FROM users WHERE email = ".$conn->quote($_POST['email']) )) && ($user = $user->fetch()) && ($user['email'] == $_POST['email'])){

  echo "El email ya esta registrado. Use uno diferente";
  echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";

}else{

  $query = "UPDATE users SET email = " . $conn->quote($_POST['email']) . " WHERE id = " . $_SESSION['id'];

  if ($conn->query($query)){
    echo "Cambios realizados con exito.";
    echo "<script>setTimeout(function(){document.forms['volver'].submit()},2000);</script>";
  }else{
    echo "Hubo un error al realizar los cambios. Intente nuevamente mas tarde.";
    echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
  }

}


}else{
  echo "No se ingresaron datos. Regresando a visualizaci&oacute;n de cuenta.";
  echo "<script>setTimeout(function(){document.forms['error'].submit()},2000);</script>";
}


?>
</h2>
</div>
</div>
