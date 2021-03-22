<?php

/*
Ejemplo de uso:

<table>
	<tr> <th>Id:</th> <th>uLogin:</th> <th>uPassword:</th> <th>uRole:</th> </tr>
<?php
	$userRecord->fetchRecordSet();
	while ($next = $userRecord->getNextRecord()){
		echo "<tr> <td>{$next->id}</td> <td>{$next->uLogin}</td> <td>{$next->uPassword}</td> <td>{$next->uRole}</td> </tr>";
	}
?>
</table>

*/

class TarjetaInstance {
  public $idTarjeta;
  public $nroTarjeta;
  public $titular;
  public $vencimiento;
  public $idUsuario;


  public function __construct() {
    $idTarjeta = 0;
    $nroTarjeta = 0;
    $titular = '';
    $vencimiento = '';
    $idUsuario = 0;
    }

    public function setValues($nroTarjeta,$titular,$dniTitular,$vencimiento,$idUsuario) {
      $this->idTarjeta = 0;
      $this->nroTarjeta = $nroTarjeta;
      $this->titular = $titular;
      $this->vencimiento = $vencimiento;
      $this->idUsuario = $idUsuario;
      }

      public function getValues() {
        return array(
          'idTarjeta'=>$this->idTarjeta,
          'nroTarjeta'=>$this->nroTarjeta,
          'titular'=>$this->titular,
          'vencimiento'=>$this->vencimiento,
          'idUsuario'=>$this->idUsuario
        );
        }

}

class TarjetaDB{
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
    $this->current = new TarjetaInstance();
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

    public function getFiltro(){
      return $this->filtro;
    }
    public function getCampos(){
      return $this->campos;
    }

    public function setOtros($newOtros){
      $this->otros = $newOtros;
    }
    public function getOtros(){
      return $this->otros;
    }

  public function fetchRecordSet($conn) {
    try {
      $this->result = $conn->query("SELECT {$this->campos} FROM tarjetas ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new TarjetaInstance();
      $current->idTarjeta = $row['idTarjeta'];
      $current->nroTarjeta = $row['nroTarjeta'];
      $current->titular = $row['titular'];
      $current->vencimiento = $row['vencimiento'];
      $current->idUsuario = $row['idUsuario'];
      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query('INSERT INTO
          tarjetas (
            nroTarjeta,
            titular,
            vencimiento,
            idUsuario )
          VALUES (
            '.$conn->quote($this->current->nroTarjeta).',
            '.$conn->quote($this->current->titular).',
            '.$conn->quote($this->current->vencimiento).',
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
