<?php




	class ConsultasCapitulo{
		public function cargarCapitulo($idLibro, $nroCapitulo, $pathFile, $esCapituloFinal, $fechaPublicacion, $fechaVencimiento){
			//include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "capitulos";
			$sql = "INSERT INTO $tabla (idLibro,nroCapitulo,pathFile,esCapituloFinal,fechaPublicacion,fechaVencimiento) values(:idLibro, :nroCapitulo, :pathFile, :esCapituloFinal, :fechaPublicacion, :fechaVencimiento)";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idLibro',$idLibro);
			$statement->bindParam(':nroCapitulo',$nroCapitulo);
			$statement->bindParam(':pathFile',$pathFile);
			$statement->bindParam(':esCapituloFinal',$esCapituloFinal);
			$statement->bindParam(':fechaPublicacion',$fechaPublicacion);
			$statement->bindParam(':fechaVencimiento',$fechaVencimiento);
			if(!$statement){
				return "Error al cargar el capitulo";
			}
			else {
				$statement->execute();
				return "Se cargo el capitulo con exito";
			}


		}

		public function eliminarCapitulo($id){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			//include	 "C:/wamp64/www/bookflix/resources/framework/DBconfig.php";
			$tabla = "capitulos";
			$sql = "DELETE FROM $tabla where idLibro = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idTrailer',$id);
			if (!$statement){
				return "Error al borrar el elemento con id: $id";
			}
			else{
				$statement->execute();
				return "Elemento con id $id eliminado satisfactoriamente";
			}


		}

		public function verCapitulo($id){
			include "../../resources/framework/DBconfig.php";
			//include	 "C:/wamp64/www/bookflix/resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";
			//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.novedad.php";

			$filas = null;
			$tabla = "capitulos";
			$sql = "SELECT * from $tabla where idTrailer = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":idTrailer", $id);
			$statement->execute();
			while ($result = $statement->fetch()){
				$filas[] = $result;
			}
			return $filas;

		}

		public function modificarCapitulo($campo, $valor, $id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";
			//include	 "C:/wamp64/www/bookflix/resources/framework/DBconfig.php";
			//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.novedad.php";

			$tabla = "capitulos";
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
