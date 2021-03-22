<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.novedad.php";
$novedades = new NovedadDB();
?>
<table>
	<tr> <th>Id:</th> <th>titulo:</th> <th>descripcion:</th> <th>foto:</th> <th>video:</th> </tr>
<?php
	$novedades->fetchRecordSet($conn);
	while ($next = $novedades->getNextRecord()){
		echo "<tr> <td>{$next->idNovedad}</td> <td>{$next->titulo}</td> <td>{$next->descripcion}</td> <td>{$next->foto}</td> <td>{$next->video}</td> </tr>";
	}
?>
</table>

*/

class NovedadInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idNovedad;
  public $contenido;
  public $foto;
  public $video;
  public $descripcion;
  public $titulo;

  public function __construct() {
    $this->idNovedad = 0;
    $this->contenido = '';
    $this->foto = '';
    $this->video = '';
    $this->descripcion = '';
    $this->titulo = '';
    }

    public function setValues($contenido,$foto,$video,$descripcion,$titulo) {
      $this->idNovedad = 0;
      $this->contenido = $contenido;
      $this->foto = $foto;
      $this->video = $video;
      $this->descripcion = $descripcion;
      $this->titulo = $titulo;
      }

      public function getValues() {
        return array(
          'titulo'=>$this->titulo,
          'descripcion'=>$this->descripcion,
          'foto'=>$this->foto,
          'video'=>$this->video,
          'idNovedad'=>$this->idNovedad,
          'contenido'=>$this->contenido
        );
        }


}

class NovedadDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
  private $result;
  private $current;
  private $filtro;
  private $campos;
  private $otros;


  public function __construct() {
    $this->result = null;
    $this->filtro = '';
    $this->campos = '*';
    $this->otros = '';
    }


  public function setFiltro($newFiltro){
    $this->filtro = "WHERE $newFiltro";
  }

  public function resetFiltro(){
    $this->filtro = "";
  }

  public function setCampos($newCampos){
    $this->campos = $newCampos;
  }
  public function getCampos(){
    return $this->campos;
  }
  public function getFiltro(){
    return $this->filtro;
  }

  public function setOtros($newOtros){
    $this->otros = $newOtros;
  }
  public function getOtros(){
    return $this->otros;
  }

  public function fetchRecordSet($conn = null) {
    try {
      $this->result = $conn->query("SELECT {$this->campos} FROM novedades ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new NovedadInstance();
      $current->idNovedad = $row['idNovedad'];
      $current->contenido = $row['contenido'];
      $current->foto = $row['foto'];
      $current->video = $row['video'];
      $current->descripcion = $row['descripcion'];
      $current->titulo = $row['titulo'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query("INSERT INTO
          novedades (
            contenido,
            foto,
            video,
            descripcion,
            titulo )
          VALUES (
            ".$conn->quote($current->contenido).",
            {$current->foto},
            {$current->video},
            ".$conn->quote($current->descripcion).",
            ".$conn->quote($current->titulo)."
          )" );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }



  }

?>
