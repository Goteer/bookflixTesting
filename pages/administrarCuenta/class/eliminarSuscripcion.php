<form id="volverForm" style="display:none" method="post" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/eliminarSuscripcion.php"/>
</form>

<form method="POST" id="cerrarSesion" action="../../cerrar_sesion.php">
</form>

<?php


if (!isset($_SESSION['id'])){
  echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

  echo "Error interno: No se recibio un identificador de suscripcion. Intente nuevamente.<br>";
  echo "<script>setTimeout(function(){document.forms['volverForm'].submit()},2000);</script>";

  echo "</h2></div></div>";
  die();
}
$id = $_SESSION['id'];
$query = "SELECT * from users where id = $id";
$statement = $conn->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$aux = $statement->fetch();
$tid = 0;

$query = "INSERT INTO usershistorial (id,uLogin,uPassword,uRole,nombre,apellido,email,dniTitular,fechaSuscripcion) values(:id,:uLogin,:uPassword,:uRole,:nombre,:apellido,:email,:dniTitular,:fechaSuscripcion)";
$statement = $conn->prepare($query);
$statement->bindParam(':id',$tid);
$statement->bindParam(':uLogin',$aux['uLogin']);
$statement->bindParam(':uPassword',$aux['uPassword']);
$statement->bindParam(':uRole',$aux['uRole']);
$statement->bindParam(':nombre',$aux['nombre']);
$statement->bindParam(':apellido',$aux['apellido']);
$statement->bindParam(':email',$aux['email']);
$statement->bindParam(':dniTitular',$aux['dniTitular']);
$statement->bindParam(':fechaSuscripcion',$aux['fechaSuscripcion']);
$statement->execute();



if ( $conn->exec("DELETE FROM users WHERE id = '".$_SESSION['id']."';
    DELETE FROM tarjetas WHERE idUsuario = '".$_SESSION['id']."';
    DELETE FROM perfiles WHERE idUsuario = '".$_SESSION['id']."';
    DELETE FROM historial WHERE idUsuario = '".$_SESSION['id']."';
    DELETE FROM librosTerminados WHERE idUsuario = '".$_SESSION['id']."';
    DELETE FROM favoritos WHERE idUsuario = '".$_SESSION['id']."'") ){ //Si se pudo borrar el user

}else{

}

echo '<br><div align="center"><div style="margin-left:10vw;margin-right:10vw" id="content-box"><h2>';

echo "Operaci&oacute;n completada. Cerrando la sesi&oacute;n. Gracias por usar Bookflix.<br>";
echo "<script>setTimeout(function(){document.forms['cerrarSesion'].submit()},3000);</script>";

echo "</h2></div></div>";
?>
