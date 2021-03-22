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
</style>

<br>
<div align="center">
<div style="background-image:linear-gradient(to bottom,#444, #222);"
<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.genero.php');

  $genero = new GeneroDB();

  $genero->setFiltro("genero like ".$conn->quote(strtolower($_POST['genero'])));
  $genero->fetchRecordSet($conn);
  if (!$genero->getNextRecord()){

    $genero->current;
    $genero->current->setValues(strtolower($_POST['genero']),$_POST['descripcion']);
  	$values = $genero->current->getValues();
  	if(
      ($values['genero'] !== null) and ($values['genero'] !== '')
    ){


  		if ($genero->insert($conn)){
        $mensaje = "Genero insertado con exito.";
      }else{
        $mensaje = "No se pudo insertar el genero.";
      }
  	}
  	else{
  		$mensaje = "Complete todos los campos";
  	};

  }else{

    $mensaje = "El genero ingresado ya existe. Ingrese uno diferente.";

  }



	echo "<h2>".$mensaje."</h2><br>"; ?>
  <form method="post" action="../../pages/navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_genero.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
  </form>

</div>
</div>
