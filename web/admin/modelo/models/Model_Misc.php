<?php 
	require_once 'Model_BD.php';

	class Model_Misc{

		static function isAdmin($datos){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Administrador WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $datos['usuario']);
		    $stmt->bindParam(':clave', $datos['clave']);

		    $stmt->execute();
		    $result = $stmt->fetch();
			$affected_rows = $stmt->rowCount();
		    
	        if($affected_rows > 0){
	        	return true;
	        }else{
	        	return false;
	        }
		    $con = null;
		}

		static function getUpdates(){
			$updates  = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Actualizacion ORDER BY idActualizacion DESC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$update = new Actualizacion($row['idActualizacion'],$row['tituloActualizacion'],$row['fechaActualizacion'],$row['descActualizacion'],$row['Usuario_email']);
				$updates[] = $update;
		    }
		    return $updates;
			$con = null;
		}

		static function insertUpdate($descriptor){
			$con = Model_BD::conectar();
			$update = $con->prepare("INSERT INTO Actualizacion (tituloActualizacion, fechaActualizacion, descActualizacion, Usuario_email) VALUES (:op, NOW(), 'El registro de tipo " . $descriptor['sec'] . " con id #" . $descriptor['id'] . " ha sido " . $descriptor['estado'] ."', :user)");

			$update->bindParam(':op', $descriptor['op']);
			$update->bindParam(':user', $_SESSION['admin']);

			$update->execute();
			$affected_rows = $update->rowCount();

			$con = null;
		}
		
		/*----------------*/
		/*--- HELPERS ---*/
		/*--------------*/

		/*--- BORRA UN DIRECTORIO ASOCIADO A UN REGISTRO ELIMINADO ---*/
		static function borraDirectorio($dir){
			$it = new RecursiveDirectoryIterator($dir);
			$files = new RecursiveIteratorIterator($it,RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
			    if ($file->getFilename() === '.' || $file->getFilename() === '..') {
			        continue;
			    }
			    if ($file->isDir()){
			        rmdir($file->getRealPath());
			    } else {
			        unlink($file->getRealPath());
			    }
			}
			rmdir($dir);
		}
	}
?>