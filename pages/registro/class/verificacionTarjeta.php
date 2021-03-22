<?php

$message = '';

function verificarTarjeta($nroTarjeta, $nroSeguridad, $nombreTitular, $venc){
  $message = '';
  if ( (time() - strtotime($venc)) >= 0) { //Si la fecha "venc" ya paso...
    $message = $message."- Tarjeta esta vencida.";
    return false;
  }
  if ( strlen($nroTarjeta) < 10 ) {
    $message = $message."- Nro de tarjeta no valido.";
    return false;
  }

  return true;
}




?>
