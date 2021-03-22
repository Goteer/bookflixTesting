
<?php


require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.tarjeta.php");
require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.user.php");

require_once($_SERVER['DOCUMENT_ROOT']."/pages/registro/class/verificacionTarjeta.php");
?>
<form method="POST" id="volverForm" action="../navigation/nav.php">
<input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>
<form method="POST" id="error" action="../navigation/nav.php">
<input type="hidden" name="target_page" value="/pages/administrarCuenta/cambiarTarjeta.php"/>
</form>


<br>
<div align="center">

  <div id="content-box" style="width:90vw;">
<h2>
    <?php
    //-------------------------

    $_SESSION['nroTarjeta'] = $_POST['nroTarjeta'];
    //$_SESSION['codSeg'] = $_POST['codSeg'];
    $_SESSION['nombreTitular'] = $_POST['nombreTitular'];
    $_SESSION['vencimiento'] = $_POST['vencimiento'];


    $vencTraducido = '20'.substr($_POST['vencimiento'],-2,2).'-'.substr($_POST['vencimiento'],0,2).'-01';

    if (verificarTarjeta($_POST['nroTarjeta'],$_POST['codSeg'],$_POST['nombreTitular'],$vencTraducido)){


            $tarjetaActual = new TarjetaDB();
            $tarjetaActual->setFiltro("idUsuario = ".$_SESSION['id'] );
            $tarjetaActual->fetchRecordSet($conn);
            $tarjetaActualInstance = $tarjetaActual->getNextRecord();



              if ($conn->query("UPDATE tarjetas SET nroTarjeta = ".$conn->quote($_POST['nroTarjeta']).", vencimiento = '".$vencTraducido."', titular = ".$conn->quote($_POST['nombreTitular'])." WHERE idUsuario = ".$conn->quote($_SESSION['id'])  )   ){
                //SE ACTUALIZO LA TARJETA
                //Se limpian los datos
                $_SESSION['nroTarjeta'] = null;
                //$_SESSION['codSeg'] = null;
                $_SESSION['nombreTitular'] = null;
                $_SESSION['vencimiento'] = null;

              }else{
                echo "Error al actualizar la tarjeta en la base de datos.";
                echo '<script>setTimeout(function(){document.forms["error"].submit()},2000);</script>';
                //Habria que borrar el perfil y el usuario
                die();
              }




        //A ESTA ALTURA ESTAN TODAS LAS COSAS CORRECTAMENTE AGREGADAS
        ?>
         Tarjeta actualizada! El proximo cargo sera realizado a la nueva tarjeta.

      <?php
      echo '<script>setTimeout(function(){document.forms["volverForm"].submit()},4000);</script>';


    }else{ //Si la tarjeta no es valida/esta vencida.

        if (substr($_POST['vencimiento'],0,2) > 30) {
          echo "La fecha de vencimiento ingresada no es valida";
        }else{
          echo "La tarjeta est&aacute; ingresada esta vencida o el numero no es valido.";
        }

        echo '<script>setTimeout(function(){document.forms["error"].submit()},2000);</script>';

      }


    ?>
  </h2>



  </div>

</div>
