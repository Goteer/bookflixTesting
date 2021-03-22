<form style="display:none" method="POST" id="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>



<br>
<div align="center">

<div id="content-box" style="width:70vw;">
<br>
<form  method="POST" id="cambiarPlan" action="../navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/eliminarSuscripcion.php"/>

    <h2>&iquest;Confirma que desea cancelar su suscripci&oacute;n?</h2><br>
    <p>Si cancela su suscripci&oacute;n, recibir&aacute; el cargo de este mes en su tarjeta (A no ser que ya lo haya recibido normalmente).</p><br>
    <p>Plan de suscripci&oacute;n actual: <b style="font-size:24px;"><?= ($_SESSION['role'] != 'premium')?'Plan Com&uacute;n':'Plan Premium' ?><b/> </p><br>



    <button type="button" class="botonLeer" onClick="document.getElementById('volverForm').submit();">Volver</button>&nbsp;
    <button type="button" class="botonLeer" onClick="document.getElementById('cambiarPlan').submit();">Continuar</button>

</form>

</div>
</div>
