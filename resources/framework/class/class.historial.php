<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.historial.php";
$historial = new HistorialDB();
?>
<table>
	<tr> <th>idLectura:</th> <th>$idLibro:</th> <th>idUsuario:</th> <th>idPerfil:</th> </tr>
<?php
	$historial->fetchRecordSet($conn);
	while ($next = $historial->getNextRecord()){
		echo "<tr> <td>{$next->idLectura}</td> <td>{$next->$idLibro}</td> <td>{$next->$idUsuario}</td> <td>{$next->$idPerfil}</td> </tr>";
	}
?>
</table>

*/

class HistorialInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idLectura;
  public $idLibro;
  public $idUsuario;
  public $idPerfil;
  public $capitulo;

  public function __construct() {
    $this->idLectura = 0;
    $this->idLibro = 0;
    $this->idUsuario = 0;
    $this->idPerfil = 0;
    $this->capitulo = 0;
    }

    public function setValues($idLibro,$idUsuario,$idPerfil,$capitulo) {
      $this->idLectura = 0;
      $this->idLibro = $idLibro;
      $this->idUsuario = $idUsuario;
      $this->idPerfil = $idPerfil;
      $this->capitulo = $capitulo;
      }

      public function getValues() {
        return array(
          'idUsuario'=>$this->idUsuario,
          'idPerfil'=>$this->idPerfil,
          'idLectura'=>$this->idLectura,
          'idLibro'=>$this->idLibro,
          'capitulo'=>$this->capitulo
        );
        }


}

class HistorialDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
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
      $this->result = $conn->query("SELECT {$this->campos} FROM historial ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new HistorialInstance();
      $current->idLectura = $row['idLectura'];
      $current->idLibro = $row['idLibro'];
      $current->idUsuario = $row['idUsuario'];
      $current->idPerfil = $row['idPerfil'];
      $current->idPerfil = $row['capitulo'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query("INSERT INTO
          historial (
            idLibro,
            idUsuario,
            idPerfil,
          capitulo )
          VALUES (
            {$this->idLibro},
            {$this->idUsuario},
            {$this->idPerfil},
            {$this->capitulo}
          )" );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }



  }

?>
