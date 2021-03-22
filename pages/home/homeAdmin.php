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

.botonMenu {
  display: inline;
  padding-left: 10px;
  padding-right: 10px;
}
</style>
<form id="homeForm" method="post" action="../navigation/nav.php" style="display:inline;">
  <input type="hidden" name="target_page" value="/pages/home/home.php"/>
</form>


<div align="center">
<div class="cuadro-listado no-margin" style="width:98%;padding-left:10px;padding-right:10px" align="center">

  <div class="row">
    <button style="position:absolute;left:25px;top:80px" onclick="document.getElementById('homeForm').submit();">Ir al home de usuario</button>
    <h2>Panel de control de administraci&oacute;n</h2>

    <hr>
  </div>
  <div class="row">

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todos los libros</button></a>
      </form>


      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleLibro/cargar_libro_form.php"/>
        <a onclick="this.parentNode.submit();"><button>Cargar Libro</button></a>
      </form>


      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleNovedad/listar_Novedad.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todas las novedades</button></a>
      </form>

  </div>

  <div class="row">

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_autor.php"/>
        <a onclick="this.parentNode.submit();"><button>Cargar un autor</button></a>
      </form>

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_genero.php"/>
        <a onclick="this.parentNode.submit();"><button>Cargar un genero</button></a>
      </form>

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_editorial.php"/>
        <a onclick="this.parentNode.submit();"><button>Cargar una editorial</button></a>
      </form>

  </div>

  <div class="row">

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/listar_trailer.php"/>
        <a onclick="this.parentNode.submit();"><button>Ver todos los Trailers</button></a>
      </form>

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/detalleTrailer/cargarTrailerForm.php"/>
        <a onclick="this.parentNode.submit();"><button>Cargar Trailer</button></a>
      </form>

  </div>

  <div class="row">

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/reportes/reportes_suscriptores.php"/>
        <input type="hidden" name="fechaDesde" value=""/>
        <input type="hidden" name="fechaHasta" value=""/>
        <a onclick="this.parentNode.submit();"><button>Reporte de Suscriptores</button></a>
      </form>

      <form class="botonMenu" method="post" action="../navigation/nav.php">
        <input type="hidden" name="target_page" value="/pages/admin/reportes/reportes_libros.php"/>
        <a onclick="this.parentNode.submit();"><button>Reporte de Libros</button></a>
      </form>

  </div>

</div>
</div>
