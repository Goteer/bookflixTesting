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
<div align="center" width="100%">
<div class="cuadro-listado">
  <form id="datos" method="POST" action="">
    <input type="hidden" name="target_page" value="/pages/admin/reportes/reportes_suscriptores.php"/>
    <table>
        <tr>
          <td>Desde</td>
          <td><input id="fechaDesde" type="text" value="" name="fechaDesde" min="<?= date('Y-m-d') ?>" required></td>
        </tr>
        <tr>
          <td>Hasta</td>
          <td><input id="fechaHasta" type="text" value="" name="fechaHasta" min="<?= date('Y-m-d') ?>" required></td>
        </tr>
        <tr>

        <td>&nbsp;</td>

    </table>
    <button class="boton-buscar" onclick="this.parentNode.submit();">Buscar</button>
  </form>
</div>
</div>

<script src="/js/jquery-3.5.1.min.js" ></script>
<script src="/js/bootstrap.min.js" ></script>
<script src="/js/bootstrap-datepicker.js" ></script>



<?php

  $where = "";
  if (($_POST['fechaDesde']) > ($_POST['fechaHasta'])){
    echo "<div align='center'>Las fechas son incorrectas</div>";
    $where ="";
  }
  else{
  if (($_POST['fechaDesde'] != "")&&($_POST['fechaHasta'] != "")){
    $where = "where fechaSuscripcion >= '".$_POST['fechaDesde']." 00:00:00' AND fechaSuscripcion <= '".$_POST['fechaHasta']." 23:59:99'";
  }
  }

  include "../../resources/framework/DBconfig.php";
  $filas = null;
  $tabla = "users";
  $sql = "SELECT nombre,apellido,email,uRole,fechaSuscripcion,id from $tabla $where UNION SELECT nombre,apellido,email,uRole,fechaSuscripcion,id from usershistorial $where ORDER BY fechaSuscripcion DESC";
  $statement = $conn->prepare($sql);
  $statement->execute();




?>

<div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-2"> Nombre </div>
    <div class="col-md-2"> Email </div>
    <div class="col-md-3"> Tipo de Suscripcion </div>
    <div class="col-md-3"> Fecha de suscripcion </div>
    <div class="col-md-2"> Cuenta activa? </div>
  </h2>
  <br>
</div>
<?php
while ($next = $statement->fetch()){
?>
  <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-2"> <?= $next['nombre'] . ' ' . $next['apellido']?>  </div>
    <div class="col-md-2"> <?= $next['email']?></div>
    <div class="col-md-3"> <?= $next['uRole']?>  </div>
    <div class="col-md-3"> <?= $next['fechaSuscripcion']?>  </div>
    <div class="col-md-2"> <?php if($next['id']==0){echo "NO";}else{echo "SI";} ?>  </div>
  </div>
<?php
}
?>

<script>
$('#fechaDesde').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    language: "es"
});
$('#fechaHasta').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    language: "es"
});
</script>
