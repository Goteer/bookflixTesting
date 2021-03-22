<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.perfil.php";
$perfiles = new PerfilDB();
?>
<table>
	<tr> <th>idPerfil:</th> <th>$nombre:</th> <th>$idUsuario:</th></tr>
<?php
	$perfiles->fetchRecordSet($conn);
	while ($next = $perfiles->getNextRecord()){
		echo "<tr> <td>{$next->idPerfil}</td> <td>{$next->$nombre}</td> <td>{$next->$idUsuario}</td> </tr>";
	}
?>
</table>

*/

class PerfilInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idPerfil;
  public $nombre;
  public $idUsuario;

  public function __construct() {
    $this->idPerfil = 0;
    $this->nombre = '';
    $this->idUsuario = 0;
    }

    public function setValues($nombre,$idUsuario) {
      $this->idPerfil = 0;
      $this->nombre = $nombre;
      $this->idUsuario = $idUsuario;
      }

      public function getValues() {
        return array(
          'idUsuario'=>$this->idUsuario,
          'idPerfil'=>$this->idPerfil,
          'nombre'=>$this->nombre
        );
        }


}

class PerfilDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
  private $result;
  public $current;
  private $filtro;
  private $campos;
  private $otros;


  public function __construct() {
    $this->result = null;
    $this->filtro = '';
    $this->campos = '*';
    $this->otros = '';
    $this->current = new PerfilInstance();
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
      $this->result = $conn->query("SELECT {$this->campos} FROM perfiles ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new PerfilInstance();
      $current->idPerfil = $row['idPerfil'];
      $current->nombre = $row['nombre'];
      $current->idUsuario = $row['idUsuario'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query('INSERT INTO
          perfiles (
            nombre,
            idUsuario )
          VALUES (
            '.$conn->quote($this->current->nombre).',
            '.$conn->quote($this->current->idUsuario).'
          )' );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
      return false;
    }
    $conn = null;
    return true;
  }



  }

?>
