<head>
  <script src="/js/jquery-3.5.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.libro.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.autor.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.editorial.php";
include_once $_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.genero.php";

//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.libro.php";
//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.autor.php";
//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.editorial.php";
//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.genero.php";

$autores = new AutorDB();
$editoriales = new EditorialDB();
$generos = new GeneroDB();

$autores->fetchRecordSet($conn);
$editoriales->fetchRecordSet($conn);
$generos->fetchRecordSet($conn);

$page = (isset($_POST['page']))?($_POST['page']):(0);

$bus_titulo = (isset($_POST['bus_titulo'])and $_POST['bus_titulo'] != '')?($_POST['bus_titulo']):('%');
$bus_autor = (isset($_POST['bus_autor']))?($_POST['bus_autor']):('%');
$bus_genero = (isset($_POST['bus_genero']))?($_POST['bus_genero']):('%');
$bus_editorial = (isset($_POST['bus_editorial']))?($_POST['bus_editorial']):('%');
//echo "Vars: $bus_titulo,$bus_autor,$bus_genero,$bus_editorial";

$where_string = "WHERE lower(libros.nombre) like ".$conn->quote("%".strtolower($bus_titulo)."%")." AND generos.idGenero like ".$conn->quote($bus_genero)." AND
autores.idAutor like ".$conn->quote($bus_autor)." AND editoriales.idEditorial like ".$conn->quote($bus_editorial);

$sort = '';
if (isset($_POST['sort'])){
switch ($_POST['sort']){
  case 'populares': $sort = "ORDER BY puntaje DESC";
  break;
  case 'nuevos': $sort = "ORDER BY fechaPublicacion DESC"; //
  break;

  }
}

$conn->query("DROP TABLE IF EXISTS temp;");
$conn->query("CREATE TEMPORARY TABLE temp SELECT idLibro,AVG(puntaje) AS puntaje FROM resenas GROUP BY idLibro;");
$queryCount = $conn->query(
  "SELECT COUNT(*) as count FROM libros
  LEFT JOIN temp ON libros.idLibro = temp.idLibro
  LEFT JOIN autores ON libros.idAutor = autores.idAutor
  LEFT JOIN editoriales ON libros.idEditorial = editoriales.idEditorial
  LEFT JOIN generos ON libros.idGenero = generos.idGenero ".$where_string.";");

$cantidadTotal = $queryCount->fetchColumn();
$conn->query("DROP TEMPORARY TABLE temp;");
$librosPorPagina = 10;
$cantPaginas = ceil($cantidadTotal/$librosPorPagina);



$conn->query("DROP TABLE IF EXISTS temp;");
$conn->query("CREATE TEMPORARY TABLE temp SELECT idLibro,AVG(puntaje) AS puntaje FROM resenas GROUP BY idLibro;");
$queryLibros = $conn->query(
  "SELECT
  libros.idLibro,
  libros.porCapitulos,
  libros.nombre AS titulo,
  libros.fechaPublicacion ,
  libros.fechaVencimiento,
  autores.nombre as nombre ,
  autores.apellido,
  generos.genero ,
  temp.puntaje,
  editoriales.nombre as editorial,
  IF(((libros.fechaPublicacion < NOW()) AND ((libros.fechaVencimiento > NOW()) OR (libros.fechaVencimiento IS NULL)) AND ((libros.pathFile IS NOT NULL AND libros.pathFile != '' AND libros.pathfile != '/') OR (libros.porCapitulos = 1))),1,0) as activo

  FROM libros
  LEFT JOIN temp ON libros.idLibro = temp.idLibro
  LEFT JOIN autores ON libros.idAutor = autores.idAutor
  LEFT JOIN editoriales ON libros.idEditorial = editoriales.idEditorial
  LEFT JOIN generos ON libros.idGenero = generos.idGenero ".$where_string." ".$sort." LIMIT ".trim($librosPorPagina)." OFFSET ".trim($page)*trim($librosPorPagina).";");
$conn->query("DROP TEMPORARY TABLE temp;");




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
<div align="center">
<div class="cuadro-listado" style="width:50%;padding-left:10px;padding-right:10px" align="left">
  <form id="buscar_form" method="post" action="" >
    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
    <input type="hidden" name="sort" value="<?= $sort ?>"/>
  <label>Titulo </label><br>
  <input type="text" name="bus_titulo" id="bus_titulo" style="width:25%;min-width:500px"/>&nbsp;
  <div id="buscar_filtros" class="cuad_busqueda" style="display:none;height:100%">
    <label>Autor </label><br>
    <select name="bus_autor" id="bus_autor" style="width:50%;min-width:500px">
      <option value="%">Cualquiera</option>
      <?php
      while ($next = $autores->getNextRecord()){
        echo "<option value='".$next->idAutor."'>".$next->nombre." ".$next->apellido."</option>";
      }
      ?>
    </select><br>
    <label>Genero </label><br>
    <select name="bus_genero" id="bus_genero" style="width:50%;min-width:500px">
      <option value="%">Cualquiera</option>
      <?php
      while ($next = $generos->getNextRecord()){
        echo "<option value='".$next->idGenero."'>".$next->genero."</option>";
      }
      ?>
    </select><br>
    <label>Editorial </label><br>
    <select name="bus_editorial" id="bus_editorial" style="width:50%;min-width:500px">
      <option value="%">Cualquiera</option>
      <?php
      while ($next = $editoriales->getNextRecord()){
        echo "<option value='".$next->idEditorial."'>".$next->nombre."</option>";
      }
      ?>
    </select>
  </div>
  </form>
  <button class="boton-buscar" onclick="document.getElementById('buscar_form').submit();">Buscar</button>
  <button class="boton-busqueda" onclick="toggleView(document.getElementById('buscar_filtros'),this);">Mas Filtros</button><br>
</div>
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">

<?php
  if ($cantidadTotal <= 0){
    echo "<h2> No se encontraron libros.</h2>
    </div>";
  }else{
?>

  <div class="row no-margin" width="100%" style="padding-bottom:10px">
    <br>
    <h2>
    <div class="col-md-3"> Titulo </div>
    <div class="col-md-1"> Editorial </div>
    <div class="col-md-1"> Autor </div>
    <div class="col-md-1"> Genero </div>
    <div class="col-md-1"> Publ. y Venc. </div>
    <div class="col-md-1"> &iquest;Activo? </div>
    <div class="col-md-1"> Puntaje </div>
    <div class="col-md-3"> Acciones </div>
  </h2>
  <br>
</div>
<?php
while ($next = $queryLibros->fetch()){
?>
  <div class="row" id="fila" style="padding-top:10px;padding-bottom:10px">
    <div class="col-md-3"> <h3><?= $next['titulo'] ?></h3> </div>
    <div class="col-md-1"> <?= $next['editorial']?></div>
    <div class="col-md-1"> <?= $next['nombre'] . ' ' . $next['apellido']?>  </div>
    <div class="col-md-1"> <?= $next['genero']?>  </div>
    <div class="col-md-1"> Publicado:<br><?= date("d-m-Y",strtotime($next['fechaPublicacion']))?><br>Vence:<br><?= date("d-m-Y",strtotime($next['fechaVencimiento']))?>  </div>
    <div class="col-md-1"> <?= ($next['activo'] == 1)?'SI':'NO' ?>  </div>
    <div class="col-md-1" style="font-weight: bold;"> <?php echo (isset($next['puntaje']) ? round($next['puntaje'],1) : "Sin calcular"); ?> </div>
    <div class="col-md-3">
      <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="action" value="update"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editar_libro_form.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Editar libro</button></a>
      </form >
      <form style="display:inline;" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Ver libro</button></a>
      </form >
      <form style="display:inline;" method="post" id="borrar<?=$next['idLibro']?>" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
				<input type="hidden" name="target_page" value="/pages/admin/detalleLibro/eliminar_libro.php"/>
      </form>
      <button onclick="confirmacionEliminar(<?=$next['idLibro']?>);" class="cerrarSesion">Eliminar libro</button>
      <form style="display:inline;" method="post" id="borrarArch<?=$next['idLibro']?>" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/eliminar_archivo_libro.php"/>
      </form>
      <button onclick="confirmacionEliminarArchivo(<?=$next['idLibro']?>);" class="cerrarSesion">Eliminar Archivo Libro</button>
      <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="sort" value="<?= $_POST['sort'] ?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleCapitulo/listarCapitulosModificar.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Editar capitulo</button></a>
      </form >
      <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoComForm.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Subir archivo completo</button></a>
      </form>
      <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargarArchivoCapForm.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Subir archivo capitulo</button></a>
      </form>
      <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
        <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
        <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Modificar fecha publ./venc. Libro</button></a>
      </form>
      <?php if ($next['porCapitulos'] == 1){?>
        <form style="display:inline;" id="formulario" method="post" action="../navigation/nav.php">
          <input type="hidden" name="bookId" value="<?=$next['idLibro']?>"/>
          <input type="hidden" name="operacion" value="capitulo"/>
          <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/editarFechaPublicacion.php"/>
          <a onclick="this.parentNode.submit();"><button class="cerrarSesion">Modificar fecha publ./venc. Capitulo</button></a>
        </form>
      <?php } ?>
    </div>
  </div>

<script type="text/javascript">
    function confirmacionEliminar(formNumber)
    {
      form = document.getElementById("borrar"+formNumber);
      var respuesta = confirm("¿Estas seguro que deseas eliminar el libro?");
      if (respuesta == true){
        form.submit();
      }
    }
    function confirmacionEliminarArchivo(formNumber)
    {
      form = document.getElementById("borrarArch"+formNumber);
      var respuesta = confirm("¿Estas seguro que deseas eliminar el Archivo?");
      if (respuesta == true){
        form.submit();
      }
    }
  </script>

<?php
}
?>
<br>
<div class="nav-arrows">
  <?php if ($page > 0){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
      <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
      <input type="hidden" name="page" value="<?= $page - 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/leftArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  } ?>
  P&aacute;gina <?=$page + 1 ?> de <?=$cantPaginas?>. Libros totales: <?=$cantidadTotal?>.
  <?php if ($page < $cantPaginas - 1){ ?>
    <form style="display:inline;" method="post" action="../navigation/nav.php">
      <input type="hidden" name="bookID" value="<?=$next['idLibro']?>"/>
      <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
      <input type="hidden" name="page" value="<?= $page + 1 ?>"/>
      <a onclick="this.parentNode.submit();"><img src="../../resources/img/pagination/rightArrow.png" style="cursor:pointer" ></a>
    </form>
    <?php
  }

}?>
</div>

</div>
</div>


<script>
function toggleView(elem,cambio){

  if (elem.style.display === "none") {
    elem.style.display = "block";
    elem.style.opacity = "0%";
    cambio.innerHTML = "Menos filtros";
    setTimeout(function(x = elem) {x.style.opacity = "100%"}, 100);
  } else {
    elem.style.opacity = "0%";
    cambio.innerHTML = "Mas filtros";
    setTimeout(function(x = elem) {x.style.display = "none"}, 1000);
  }
};

$(document).ready(function() {
    $('#bus_autor').select2({
      width: 'style'
    });
    $('#bus_genero').select2({
      width: 'style'
    });
    $('#bus_editorial').select2({
      width: 'style'
    });
});


</script>
