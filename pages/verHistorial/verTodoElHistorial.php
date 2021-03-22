
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.historial.php";





$conn->query("DROP TEMPORARY TABLE IF EXISTS results");
$conn->query("
CREATE TEMPORARY TABLE results AS ( SELECT
historial.idLectura,
historial.idLibro,
historial.idUsuario,
historial.idPerfil,
libros.nombre,
libros.descripcion,
libros.pathFile,
MAX(historial.fechaAct) AS fechaAct,
COUNT(DISTINCT historial.idLibro, historial.capitulo) AS capitulosLeidos,
IF(COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo)  >= 1, COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo), 1 ) AS cantCapitulosLibro,
nvl(MAX(capitulos.esCapituloFinal),0) AS libroFinalizado,
IF((COUNT(DISTINCT historial.idLibro, historial.capitulo)) < (IF(COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo)  >= 1, COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo), 1 )), 0, 1) AS libroLeidoCompleto

FROM historial
LEFT JOIN capitulos ON historial.idLibro = capitulos.idLibro
LEFT JOIN libros ON historial.idLibro = libros.idLibro

WHERE historial.idPerfil = ".(isset($_SESSION['profileId'])?$_SESSION['profileId']:0)."
GROUP BY historial.idLibro, CASE WHEN historial.capitulo > 0 THEN 1 ELSE 0 END
ORDER BY MAX(historial.fechaAct) DESC );");

$queryLibrosCount = $conn->query("SELECT COUNT(*) AS numResultados FROM results;");

$page = (isset($_POST['page']))?($_POST['page']):(0);
$librosPorPagina = 10;
$cantidadTotal = $queryLibrosCount->fetchColumn();
$cantPaginas = ceil($cantidadTotal/$librosPorPagina);

$queryLibros = $conn->query("
SELECT * FROM results
LIMIT ".$librosPorPagina."
OFFSET ".(10*$page));

//----------------------------------



?>
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
}
#fila {
  margin: 15px 0;
  border:1px;
  border-style: solid;
  border-color: white;
  background-color: rgba(0, 0, 0, 0.35);
}
#formulario {
  display:inline;
}
#buscar_filtros{
  transition: opacity 1s;
}
.select2-results ul{
  color: black;
}

input[type="text"]{
  border-radius: 5px;
}

</style>
<BR>
  <form name="volver" method="post" action="">
  	<input type="hidden" name="target_page" value="/pages/verHistorial/verHistorial.php"/>
  	<button onclick="this.parentNode.submit();" alt="Ver historial" class="boton" style="padding-top:5px;padding-bottom:5px;margin-bottom:10px;margin-top:10px;margin-left:10px;">Volver</button>
  </form>

  <div class="row" align="center">
    <div class="col-md-6">
      <h1>Actividad por libro</h1>
      <div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
        <div class="row no-margin" width="100%" >
          <br>

          <div class="col-md-2"><h3> Fecha Ultima Actividad </h3></div>
          <div class="col-md-3"><h3> Titulo</h3> </div>
          <div class="col-md-3"><h3> Descripcion </h3></div>
          <div class="col-md-1"><h3> Caps. leidos</h3> </div>
          <div class="col-md-1"><h3> Caps. totales </h3></div>
          <div class="col-md-2"><h3> ¿Libro leido entero?</h3> </div>
        </div>
        <?php
        while ($next = $queryLibros->fetch()){
          if ($next['pathFile'] != null){
          ?>
          <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
            <div class="col-md-2"> <?= $next['fechaAct']?>  </div>
            <div class="col-md-3"> <?= $next['nombre'] ?></div>
            <div class="col-md-3"> <?= $next['descripcion'] ?> </div>
            <div class="col-md-1"> <?= $next['capitulosLeidos']?></div>
            <div class="col-md-1"> <?= $next['cantCapitulosLibro']?></div>
            <div class="col-md-2"> <?= ($next['libroLeidoCompleto'] == 1)?'Si':'No'?></div>
          </div>
          <?php


        }
        }

        if ($cantidadTotal == 0) { //Si $cantidadTotal no fue seteada, es porque no se entro al while anterior.
          echo "<h2> No se encontr&oacute; actividad en el perfil. </h2>";
        }else{



        ?>
      </div>

      <br>
      <div class="nav-arrows">
        <?php if ($page > 0){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verTodoElHistorial.php"/>
            <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
            <input type="hidden" name="pageAct" value="<?= $pageAct  ?>"/>
            <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
          </form>
          <?php
        } ?>
        P&aacute;gina <?=$page + 1 ?> de <?=$cantPaginas?>. Libros totales: <?=$cantidadTotal?>.
        <?php if ($page < $cantPaginas - 1){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verTodoElHistorial.php"/>
            <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
            <input type="hidden" name="pageAct" value="<?= $pageAct  ?>"/>
            <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
          </form>
          <?php
        }
      }





        $conn->query("
        DROP TEMPORARY TABLE IF EXISTS results2;
        CREATE TEMPORARY TABLE results2 AS (
          SELECT
          historial.idLectura,
          historial.idLibro,
          historial.idUsuario,
          historial.idPerfil,
          libros.nombre,
          libros.descripcion,
          libros.pathFile,
          historial.fechaAct,
          IF(historial.capitulo = 0,1,historial.capitulo) AS capitulo,
          FOUND_ROWS() AS numResultados

          FROM historial
          LEFT JOIN libros ON historial.idLibro = libros.idLibro

          WHERE historial.idPerfil = ".(isset($_SESSION['profileId'])?$_SESSION['profileId']:0)."

          ORDER BY historial.fechaAct DESC
          );");
          $queryActividadCount = $conn->query("SELECT COUNT(*) FROM results2;");

        $pageAct = (isset($_POST['pageAct']))?($_POST['pageAct']):(0);
        $librosPorPaginaAct = 10;
        $cantidadTotalAct = $queryActividadCount->fetchColumn();
        $cantPaginasAct = ceil($cantidadTotalAct/$librosPorPaginaAct);

        $queryActividad = $conn->query("
        SELECT * FROM results2
        LIMIT ".$librosPorPaginaAct."
        OFFSET ".(10*$pageAct));










        ?>
      </div>
    </div>

      <div class="col-md-6">
        <h1>Lecturas individuales</h1>
        <div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
          <div class="row no-margin" width="100%" >
            <br>

            <div class="col-md-2"><h3> Fecha Actividad </h3></div>
            <div class="col-md-3"><h3> Titulo</h3> </div>
            <div class="col-md-4"><h3> Descripcion </h3></div>
            <div class="col-md-2"><h3> Capitulo</h3> </div>
          </div>
          <?php
          while ($next = $queryActividad->fetch()){
            if ($next['pathFile'] != null){
            ?>
            <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
              <div class="col-md-2"> <?= $next['fechaAct']?>  </div>
              <div class="col-md-3"> <?= $next['nombre'] ?></div>
              <div class="col-md-4"> <?= $next['descripcion'] ?> </div>
              <div class="col-md-2"> <?= $next['capitulo']?></div>
            </div>
            <?php
          }
          }

          if ($cantidadTotalAct == 0 ) { //Si $cantidadTotal no fue seteada, es porque no se entro al while anterior.
            echo "<h2> No se encontr&oacute; actividad en el perfil.</h2>";
          }else{


          ?>
        </div>

        <br>
        <div class="nav-arrows">
          <?php if ($pageAct > 0){ ?>
            <form style="display:inline;" method="post" action="../navigation/nav.php">
              <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
              <input type="hidden" name="target_page" value="/pages/verHistorial/verTodoElHistorial.php"/>
              <input type="hidden" name="page" value="<?= $page ?>"/>
              <input type="hidden" name="pageAct" value="<?= $pageAct - 1 ?>"/>
              <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
            </form>
            <?php
          } ?>
          P&aacute;gina <?=$pageAct + 1 ?> de <?=$cantPaginasAct?>. Libros totales: <?=$cantidadTotalAct?>.
          <?php if ($pageAct < $cantPaginasAct - 1){ ?>
            <form style="display:inline;" method="post" action="../navigation/nav.php">
              <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
              <input type="hidden" name="target_page" value="/pages/verHistorial/verTodoElHistorial.php"/>
              <input type="hidden" name="page" value="<?= $page ?>"/>
              <input type="hidden" name="pageAct" value="<?= $pageAct + 1 ?>"/>
              <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
            </form>
            <?php
          }
        }

          $conn->query("DROP TEMPORARY TABLE results");
          $conn->query("DROP TEMPORARY TABLE results2");
          ?>
        </div>
    </div>
