
<?php


require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.user.php");
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.perfil.php");
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.tarjeta.php");
require_once($_SERVER['DOCUMENT_ROOT']."/pages/registro/class/verificacionTarjeta.php");
?>
<form method="POST" id="volverForm" action="../navigation/nav.php">
<input type="hidden" name="retorno" value="/pages/registro/ingresarDatosTarjeta.php"/>
</form>

<form method="POST" id="fin" action="/index.php">
</form>


<div align="center">

  <div class="contenido-box">
<h2>
    <?php
    //-------------------------

    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['apellido'] = $_POST['apellido'];
    $_SESSION['nroTarjeta'] = $_POST['nroTarjeta'];
    //$_SESSION['codSeg'] = $_POST['codSeg'];
    $_SESSION['nombreTitular'] = $_POST['nombreTitular'];
    $_SESSION['dniTitular'] = $_POST['dniTitular'];
    $_SESSION['vencimiento'] = $_POST['vencimiento'];
    $_SESSION['tipoSuscripcion'] = $_POST['tipoSuscripcion'];
    $vencTraducido = '20'.substr($_POST['vencimiento'],-2,2).'-'.substr($_POST['vencimiento'],0,2).'-01';

    if (verificarTarjeta($_POST['nroTarjeta'],$_POST['codSeg'],$_POST['nombreTitular'],$vencTraducido)){
      $user = new UserDB();
      $perfil = new PerfilDB();
      $tarjeta = new TarjetaDB();

      $user->setFiltro("uLogin = ".$conn->quote($_SESSION['usernameReg'])." OR email = ".$conn->quote($_SESSION['email'])." OR dniTitular = ".$_SESSION['dniTitular'] );
      $user->fetchRecordSet($conn);
      if (!$user->getNextRecord()) { //Si no se encontro el usuario en la base de datos

        $user->current->setValues($_SESSION['usernameReg'],$_SESSION['passwordReg'],$_SESSION['tipoSuscripcion'],$_SESSION['nombre'],$_SESSION['apellido'],$_SESSION['email'],$_SESSION['dniTitular']);


        if ($user->insert($conn)){ //Se crea el usuario en la base de datos
          //SE CREO EL USUARIO
          $user->setFiltro("uLogin = '".$_SESSION['usernameReg']."'");
          $user->fetchRecordSet($conn);

          if ($newUser = $user->getNextRecord()){

            //Crear perfil predeterminado
            $nombrePerfil = $_SESSION['nombre'].$_SESSION['apellido'];
            $perfil->current->setValues($nombrePerfil,$newUser->getValues()['id']);
            if ($perfil->insert($conn)){
              //SE CREO EL PERFIL

              $tarjeta->current->setValues($_SESSION['nroTarjeta'],$_SESSION['nombreTitular'],$_SESSION['dniTitular'],$vencTraducido,$newUser->getValues()['id']);
              if ($tarjeta->insert($conn)){
                //SE AGREGO LA TARJETA
                //Se limpian los datos de registro.
                $_SESSION['usernameReg'] = null;
                $_SESSION['passwordReg'] = null;
                $_SESSION['email'] = null;
                $_SESSION['nombre'] = null;
                $_SESSION['apellido'] = null;
                $_SESSION['nroTarjeta'] = null;
                //$_SESSION['codSeg'] = null;
                $_SESSION['nombreTitular'] = null;
                $_SESSION['dniTitular'] = null;
                $_SESSION['vencimiento'] = null;
                $_SESSION['tipoSuscripcion'] = null;

              }else{
                echo "Error al agregar la tarjeta a la base de datos.";
                echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';
                $conn->query('DELETE FROM users WHERE id = '.$newUser->getValues()['id'].' LIMIT 1');
                $conn->query('DELETE FROM perfiles WHERE nombre = '.$conn->quote($_POST['nombre']).'AND idUsuario = '.$newUser->getValues()['id'].' LIMIT 1');
                //Habria que borrar el perfil y el usuario
                die();
              }

            }else{
              echo "Error al crear un perfil por defecto para el usuario en la base de datos.";
              echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';
              $conn->query('DELETE FROM users WHERE uLogin = '.$conn->quote($_SESSION['usernameReg']).' LIMIT 1');
              //habria que borrar el usuario
              die();
            }


          }else{
            echo "Error: Se creo el usuario pero no se encuentra en la base de datos.";
            echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';
            $conn->query('DELETE FROM users WHERE uLogin = '.$conn->quote($_SESSION['usernameReg']).' LIMIT 1');
            //Esto deberia ser imposible, pero lo tomo en cuenta por las dudas.
            die();
          }
        }else {
          echo "Error al insertar usuario en la base de datos.";
          echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';
          //No hay nada que hacer ya que no se inserto nada

          die();
        }
        //A ESTA ALTURA ESTAN TODAS LAS COSAS CORRECTAMENTE AGREGADAS
        ?>
         Registro completado! Ya puede ingresar a su cuenta con su nombre de usuario y contrase&ntilde;a.

      <?php
      echo '<script>setTimeout(function(){document.forms["fin"].submit()},4000);</script>';
    }else{
      echo "Algun dato basico (nombre usuario, email, o dni) del usuario ya existe. Comienze el registro desde el principio por favor.";
      echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';
    }

      }else{ //Si el usuario ya existia

        echo "La tarjeta est&aacute; ingresada esta vencida o el numero no es valido.";
        echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},2000);</script>';

      }


    ?>
  </h2>



  </div>

</div>
