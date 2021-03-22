<form style="display:none" method="POST" id="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>



<br>
<div align="center">

<div id="content-box" style="width:70vw;">

<form  method="POST" id="cambiarPlan" action="../navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/cambiarPlan.php"/>

    <h2>Cambiar de plan de suscripci&oacute;n</h2><br>
    <label>Plan de suscripci&oacute;n actual: <?= ($_SESSION['role'] != 'premium')?'Com&uacute;n':'Premium' ?> </label><br>
    <select id="select_plan" name="plan_buscado" onChange="cambiarDescripcion(this,document.getElementById('descripcion_plan'));">
      <option value="none" hidden disabled selected>Elija un plan para ver mas detalles</option>
      <option value="suscriptor">Plan Com&uacute;n</option>
      <option value="premium">Plan Premium</option>
    </select><br>

    <p id="descripcion_plan">Elija un plan para obtener informacion.</p>
    <br><br>


    <button type="button" class="botonLeer" onClick="document.getElementById('volverForm').submit();">Volver</button>&nbsp;
    <button type="button" class="botonLeer" onClick="aceptarForm(document.getElementById('cambiarPlan'),document.getElementById('select_plan').value);">Continuar</button>

</form>

</div>
</div>


<script>

function aceptarForm(form,valor){
  if (valor == '<?=$_SESSION['role']?>'){
    alert("Usted ya tiene este plan. Elija otro o cancele la operación.");
  }else if(valor == 'none'){
    alert("Debe elegir algun plan para continuar.")
  }else{
    if (confirm("¿Está seguro/a? Al continuar acepta que el proximo cargo a su tarjeta sea acorde al plan que haya elegido.")){
      form.submit();
    }
  }
}

function cambiarDescripcion(dropdown,target){
  target.innerHTML = getDescripcion(dropdown.value);
}


function getDescripcion(valor){
  switch (valor){
    case 'suscriptor':
      return 'Nuestro plan mas barato: Permite crear hasta 2 perfiles.';
      break;
    case 'premium':
      return 'Para quienes necesitan más: Permite hasta 4 perfiles.';
      break;
    default:
      return 'Error: Seleccion no valida.';
      break;
  }
}


</script>
