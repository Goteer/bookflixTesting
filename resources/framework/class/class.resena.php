<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.resena.php";
$resenas = new ResenaDB();
?>
<table>
	<tr> <th>idResena:</th> <th>titulo:</th> <th>idLibro:</th> <th>puntaje:</th> </tr>
<?php
	$resenas->fetchRecordSet($conn);
	while ($next = $resenas->getNextRecord()){
		echo "<tr> <td>{$next->idResena}</td> <td>{$next->titulo}</td> <td>{$next->idLibro}</td> <td>{$next->puntaje}</td> </tr>";
	}
?>
</table>

*/

class ResenaInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idResena;
  public $contenido;
  public $idLibro;
  public $puntaje;
  public $titulo;

  public function __construct() {
    $this->idResena = 0;
    $this->contenido = '';
    $this->idLibro = 0;
    $this->puntaje = 0;
    $this->titulo = '';
    }

    public function setValues($contenido,$idLibro,$puntaje,$titulo) {
      $this->idResena = 0;
      $this->contenido = $contenido;
      $this->idLibro = $idLibro;
      $this->puntaje = $puntaje;
      $this->titulo = $titulo;
      }

      public function getValues() {
        return array(
          'titulo'=>$this->titulo,
          'idLibro'=>$this->idLibro,
          'puntaje'=>$this->puntaje,
          'idResena'=>$this->idResena,
          'contenido'=>$this->contenido
        );
        }


}

class ResenaDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
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
      $this->result = $conn->query("SELECT {$this->campos} FROM resenas ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new ResenaInstance();
      $current->idResena = $row['idResena'];
      $current->contenido = $row['contenido'];
      $current->idLibro = $row['idLibro'];
      $current->puntaje = $row['puntaje'];
      $current->titulo = $row['titulo'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query("INSERT INTO
          resenas (
            contenido,
            idLibro,
            puntaje,
            titulo )
          VALUES (
            ".$conn->quote($current->contenido).",
            {$current->idLibro},
            {$current->puntaje},
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
