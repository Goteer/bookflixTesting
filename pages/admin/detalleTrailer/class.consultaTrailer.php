<?php




	class ConsultasTrailer{
		public function cargarTrailer($titulo, $descripcion, $video, $pdf, $idLibAsociado){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "trailers";
			$sql = "INSERT INTO $tabla (titulo,descripcion,video,pdf,idLibAsociado) values(:titulo, :descripcion, :video, :pdf, :idLibAsociado)";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':titulo',$titulo);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':video',$video);
			$statement->bindParam(':pdf',$pdf);
			$statement->bindParam(':idLibAsociado',$idLibAsociado);
			if(!$statement){
				return "Error al cargar el trailer";
			}
			else {
				$statement->execute();
				return "Se cargo el trailer con exito";
			}


		}

		public function eliminarTrailer($id){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "trailers";
			$sql = "DELETE FROM $tabla where idTrailer = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idTrailer',$id);
			if (!$statement){
				return "Erro al borrar el elemento con id: $id";
			}
			else{
				$statement->execute();
				return "Elemento con id $id eliminado satisfactoriamente";
			}


		}

		public function verTrailer($id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";

			$filas = null;
			$tabla = "trailers";
			$sql = "SELECT * from $tabla where idTrailer = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":idTrailer", $id);
			$statement->execute();
			while ($result = $statement->fetch()){
				$filas[] = $result;
			}
			return $filas;

		}

		public function modificarTrailer($campo, $valor, $id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";

			$tabla = "trailer";
			$sql = "UPDATE $tabla set $campo = :valor where idTrailer = :id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":valor",$valor);
			$statement->bindParam(":id",$id);
			if(!$statement){
				return "Error al modificar el Trailer";
			}
			else {
				$statement->execute();
				return "Trailer modificado correctamente";
			}
		}


	}

?>
