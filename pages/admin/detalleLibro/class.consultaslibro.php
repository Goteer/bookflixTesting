<?php




	class ConsultasLibro{
		public function cargarLibro($nombre,$descripcion, $foto,$fechaPublicacion,$fechaVencimiento,$idAutor,$idEditorial,$idGenero,$isbn){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "libros";
			$sql = "INSERT INTO $tabla (foto,descripcion,nombre,fechaPublicacion,fechaVencimiento,idAutor,idEditorial,idGenero,isbn,pathFile) values(:foto, :descripcion, :nombre, :fechaPublicacion, :fechaVencimiento, :idAutor, :idEditorial, :idGenero, :isbn, '/')";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':foto',$foto);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':nombre',$nombre);
			$statement->bindParam(':fechaPublicacion',$fechaPublicacion);
			$statement->bindParam(':fechaVencimiento',$fechaVencimiento);
			$statement->bindParam(':idAutor',$idAutor);
			$statement->bindParam(':idGenero',$idGenero);
			$statement->bindParam(':idEditorial',$idEditorial);
			$statement->bindParam(':isbn',$isbn);
			//Podria cargarse el archivo de una, pero creo que es mejor que se agregue con el boton "subir archivo"
			if(!$statement){
				return "Error al cargar el libro";
			}
			else {
				$statement->execute();
				return "Se cargo el libro con exito";
			}


		}

		public function eliminarLibro($id){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "libros";
			$sql = "DELETE FROM $tabla where idLibro = :idLibro";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idLibro',$id);
			if (!$statement){
				return "Error al borrar el elemento con id: $id";
			}
			else{
				$statement->execute();
				return "Elemento con id $id eliminado satisfactoriamente";
			}


		}

		public function verLibro($id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.libro.php";

			$filas = null;
			$tabla = "libros";
			$sql = "SELECT * from $tabla where idLibro = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":idLibro", $id);
			$statement->execute();
			while ($result = $statement->fetch()){
				$filas[] = $result;
			}
			return $filas;

		}

		public function modificarLibro($campo, $valor, $id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.libro.php";

			$tabla = "libros";
			$sql = "UPDATE $tabla set $campo = :valor where idLibro = :id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":valor",$valor);
			$statement->bindParam(":id",$id);
			if(!$statement){
				return "Error al modificar el campo: $campo";
			}
			else {
				$statement->execute();
				return "Producto modificado correctamente";
			}
		}


	}

?>
