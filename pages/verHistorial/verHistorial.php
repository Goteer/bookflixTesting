
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
libros.porCapitulos,
COUNT(DISTINCT historial.idLibro, historial.capitulo) AS capitulosLeidos,
IF(COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo)  >= 1, COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo), 1 ) AS cantCapitulosLibro,
librosterminados.fechaAct
FROM historial
LEFT JOIN capitulos ON historial.idLibro = capitulos.idLibro
LEFT JOIN libros ON historial.idLibro = libros.idLibro
LEFT JOIN librosterminados ON historial.idLibro = librosterminados.idLibro AND historial.idUsuario = librosterminados.idUsuario AND historial.idPerfil = librosterminados.idPerfil

WHERE historial.idUsuario = ".$_SESSION['id']." AND historial.idPerfil = ".(isset($_SESSION['profileId'])?$_SESSION['profileId']:0)." AND librosterminados.fechaAct IS NULL
GROUP BY historial.idLibro, CASE WHEN historial.capitulo > 0 THEN 1 ELSE 0 END
ORDER BY MAX(historial.fechaAct) DESC );");

$queryLibrosCount = $conn->query("SELECT COUNT(*) AS numResultados FROM results;");

$page = (isset($_POST['page']))?($_POST['page']):(0);
$librosPorPagina = 10;
$cantidadTotal = $queryLibrosCount->fetch()['numResultados'];
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
  	<input type="hidden" name="target_page" value="/pages/home/home.php"/>
  	<button onclick="this.parentNode.submit();" alt="Ver historial" class="boton" style="padding-top:5px;padding-bottom:5px;margin-bottom:10px;margin-top:10px;margin-left:10px;">Volver</button>
  </form>

  <form name="verHistorial" method="post" action="">
  	<input type="hidden" name="target_page" value="/pages/verHistorial/verTodoElHistorial.php"/>
  	<button onclick="this.parentNode.submit();" alt="Ver historial completo" class="boton" style="padding-top:5px;padding-bottom:5px;margin-bottom:10px;margin-top:10px;margin-left:10px;">Actividad en detalle</i></button>
  </form>

  <div class="row" align="center" style="width:100%">
    <div class="col-md-8">
      <h1>Libros empezados</h1>
      <div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
        <div class="row no-margin" width="100%" >
          <br>

          <div class="col-md-2"><h3> Fecha Ultima Actividad </h3></div>
          <div class="col-md-3"><h3> Titulo</h3> </div>
          <div class="col-md-4"><h3> Descripcion </h3></div>
          <div class="col-md-1"><h3> Caps. leidos</h3> </div>
          <div class="col-md-1"><h3> Caps. totales </h3></div>
        </div>
        <?php
        while ($next = $queryLibros->fetch()){
          if ($next['pathFile'] != null || $next['porCapitulos'] == 1){
          ?>
          <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
            <div class="col-md-2"> <?= $next['fechaAct']?>  </div>
            <div class="col-md-3"> <?= $next['nombre'] ?></div>
            <div class="col-md-4"> <?= $next['descripcion'] ?> </div>
            <div class="col-md-1"> <?= $next['capitulosLeidos']?></div>
            <div class="col-md-1"> <?= $next['cantCapitulosLibro']?></div>
          </div>
          <?php

        }
        }

        if ($cantidadTotal == 0) { //Si $cantidadTotal no fue seteada, es porque no se entro al while anterior.
          echo "<h2> No se encontraron libros empezados. </h2>";
        }else{



        ?>
      </div>

      <br>
      <div class="nav-arrows">
        <?php if ($page > 0){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verHistorial.php"/>
            <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
            <input type="hidden" name="pageLeido" value="<?= $pageLeido  ?>"/>
            <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
          </form>
          <?php
        } ?>
        P&aacute;gina <?=$page + 1 ?> de <?=$cantPaginas?>. Libros totales: <?=$cantidadTotal?>.
        <?php if ($page < $cantPaginas - 1){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verHistorial.php"/>
            <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
            <input type="hidden" name="pageLeido" value="<?= $pageLeido  ?>"/>
            <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
          </form>
          <?php
        }

      }




        $conn->query("DROP TEMPORARY TABLE IF EXISTS results2");
        $conn->query("
        CREATE TEMPORARY TABLE results2 AS ( SELECT
        librosterminados.*,
        libros.nombre,
        libros.descripcion,
        libros.pathFile,
        libros.porCapitulos
         FROM librosterminados
        LEFT JOIN libros ON librosterminados.idLibro = libros.idLibro

        WHERE idUsuario = ".$_SESSION['id']." AND idPerfil = ".(isset($_SESSION['profileId'])?$_SESSION['profileId']:0)."
        ORDER BY librosterminados.fechaAct DESC);");

        $queryLeidoCount = $conn->query("SELECT COUNT(*) AS numResultados FROM results2;");

        $pageLeido = (isset($_POST['pageLeido']))?($_POST['pageLeido']):(0);
        $librosPorPaginaLeido = 10;
        $cantidadTotalLeido = $queryLeidoCount->fetchColumn();
        $cantPaginasLeido = ceil($cantidadTotalLeido/$librosPorPaginaLeido);

        $queryLeido = $conn->query("
        SELECT * FROM results2
        LIMIT ".$librosPorPaginaLeido."
        OFFSET ".(10*$pageLeido));










        ?>
      </div>
    </div>

    <div class="col-md-4" >
      <h1>Libros ya leidos</h1>
      <div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">
        <div class="row no-margin" width="100%" >
          <br>

          <div class="col-md-3"><h3> Fecha Ultima Actividad </h3></div>
          <div class="col-md-3"><h3> Titulo</h3> </div>
          <div class="col-md-6"><h3> Descripcion </h3></div>
        </div>
        <?php
        while ($next = $queryLeido->fetch()){
          if ($next['pathFile'] != null || $next['porCapitulos'] == 1){
          ?>
          <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
            <div class="col-md-3"> <?= $next['fechaAct']?>  </div>
            <div class="col-md-3"> <?= $next['nombre'] ?></div>
            <div class="col-md-6"> <?= $next['descripcion'] ?> </div>
          </div>
          <?php

        }
        }

        if ($cantidadTotalLeido == 0) { //Si $cantidadTotal no fue seteada, es porque no se entro al while anterior.
          echo "<h2> No se encontraron libros marcados como leidos.</h2>";
        }else{



        ?>
      </div>

      <br>
      <div class="nav-arrows">
        <?php if ($pageLeido > 0){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verHistorial.php"/>
            <input type="hidden" name="pageLeido" value="<?= $pageLeido - 1 ?>"/>
            <input type="hidden" name="page" value="<?= $page  ?>"/>
            <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
          </form>
          <?php
        } ?>
        P&aacute;gina <?=$pageLeido + 1 ?> de <?=$cantPaginasLeido?>. Libros totales: <?=$cantidadTotalLeido?>.
        <?php if ($pageLeido < $cantPaginasLeido - 1){ ?>
          <form style="display:inline;" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
            <input type="hidden" name="target_page" value="/pages/verHistorial/verHistorial.php"/>
            <input type="hidden" name="pageLeido" value="<?= $pageLeido + 1 ?>"/>
            <input type="hidden" name="page" value="<?= $page  ?>"/>
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
