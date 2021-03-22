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


<?php


  include "../../resources/framework/DBconfig.php";
  $sql = "SELECT libros.nombre, libros.pathFile, libros.idLibro, libros.foto, COUNT(DISTINCT historial.idPerfil) as cantHist, COUNT(DISTINCT librosterminados.idPerfil) as cantTerm from libros LEFT JOIN historial on libros.idLibro = historial.idLibro left join librosterminados on libros.idLibro = librosterminados.idLibro GROUP BY libros.idLibro ORDER BY COUNT(DISTINCT historial.idPerfil)+COUNT(DISTINCT librosterminados.idPerfil) DESC";
  $statement = $conn->prepare($sql);
  $statement->execute();



?>
  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
      <div class="col-md-3"> Titulo </div>
      <div class="col-md-3"> Foto </div>
      <div class="col-md-3"> Perfiles Leyendolo </div>
      <div class="col-md-3"> Perfiles que lo terminaron </div>
    </h2>
    <br>
  </div>
<?php
  $cant=0;
  while ($next = $statement->fetch()){


      $cant += 1;
?>
  <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-3"> <h3><?= $next['nombre'] ?></h3> </div>
    <div class="col-md-3"> <img onerror="this.src='../../resources/img/news-icon.png';" style="max-width:50%;" src="<?= $next['foto']?>"/> </div>
    <div class="col-md-3"><h3> <?= $next['cantHist']-$next['cantTerm']?></h3> </div>
    <div class="col-md-3"><h3> <?= $next['cantTerm']?></h3>  </div>
  </div>


<?php
  
}
if ($cant == 0) {
  echo " <div class='col-md-12'> <h3>No hay libros cargados</h3> </div>";
}













  /*
  $libros = null;
  $tabla = "libros";
  $sql = "SELECT * from $tabla";
  $statement = $conn->prepare($sql);
  $statement->execute();

  while ($result = $statement->fetch()){
    $libros[] = $result;

    $filas = null;
    $tabla = "historial";
    $sql = "SELECT COUNT(idLibro) from $tabla where idLibro = $result['idLibro'] AS cantidad";
    $statement2 = $conn->prepare($sql);
    $statement2->execute();
    $result2 = $statement2->fetch()
    $filas[] = $result2;

  }
  */
?>
