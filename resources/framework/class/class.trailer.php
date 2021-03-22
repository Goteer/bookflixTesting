<?php
class TrailerInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idTrailer;
  public $titulo;
  public $descripcion;
  public $video;
  public $pdf;
  public $idLibAsociado;


  public function __construct() {
    $this->idTrailer = 0;
    $this->titulo = '';
    $this->descripcion = '';
    $this->video = '';
    $this->pdf = '';
    $this->idLibAsociado = '';
    }

    public function setValues($titulo,$descripcion,$video,$pdf,$idLibAsociado) {
      $this->idTrailer = 0;
      $this->titulo = $titulo;
      $this->descripcion = $descripcion;
      $this->video = $video;
      $this->pdf = $pdf;
      $this->idLibAsociado = $idLibAsociado;
      }

      public function getValues() {
        return array(
          'titulo'=>$this->titulo,
          'descripcion'=>$this->descripcion,
          'video'=>$this->video,
          'idTrailer'=>$this->idTrailer,
          'pdf'=>$this->pdf,
          'idLibAsociado'=>$this->idLibAsociado
        );
        }


}

class TrailerDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
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
      $this->result = $conn->query("SELECT {$this->campos} FROM trailers ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new TrailerInstance();
      $current->idTrailer = $row['idTrailer'];
      $current->titulo = $row['titulo'];
      $current->descripcion = $row['descripcion'];
      $current->video = $row['video'];
      $current->pdf = $row['pdf'];
      $current->idLibAsociado = $row['idLibAsociado'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query("INSERT INTO
          trailers (
            titulo,
            descripcion,
            video,
            pdf,
            idLibAsociado )
          VALUES (
            ".$conn->quote($current->titulo).",
            ".$conn->quote($current->descripcion).",
            {$current->video},
            {$current->pdf},
            {$current->idLibAsociado}
          )" );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }



  }

?>
