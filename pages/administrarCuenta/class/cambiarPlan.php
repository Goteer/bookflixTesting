<form style="display:none" method="POST" id="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>
<br>
<div align="center">
<div id="content-box" style="width:40vw">
<h2>
<?php

$cantPerfiles = $conn->query("SELECT COUNT(*) FROM perfiles WHERE idUsuario = '".$_SESSION['id']."'");
$cantPerfiles = $cantPerfiles->fetchColumn();


if (!isset($_POST['plan_buscado'])){
  echo "Hubo un error: No se recibio el plan a utilizar. Intente nuevamente.";
}else{

  if (($_POST['plan_buscado'] == 'suscriptor') && ($cantPerfiles>2)){
    echo "Tiene demasiados perfiles como para tener un plan regular. Max: 2 Perfiles.";
  }else{

    if ($conn->exec("UPDATE users SET uRole = '".$_POST['plan_buscado']."' WHERE id = '".$_SESSION['id']."'")){
      echo "Se actualizo el plan a "; echo ($_POST['plan_buscado'] == 'premium')?'Plan Premium':'Plan Com&uacute;n';
    }else{
      echo "Hubo un error. Intente nuevamente.";
    }

  }


}

 ?>
<br>
Volviendo...
</h2>
</div>
</div>

<script>

setTimeout(function(){document.forms['volverForm'].submit()},3000);

</script>
