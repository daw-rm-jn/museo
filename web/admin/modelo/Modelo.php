<?php 
	require 'ListaModelos.php';

	class Modelo{

		/*--- CONEXIÓN A LA BBDD---*/
		public function conectar(){
			$host = 'localhost';
			$usuario = 'root';
			$clave = 'root';

			try {
			    $con = new PDO("mysql:host=$host;dbname=bd_Museo;charset=utf8", $usuario, $clave);
			    return $con;
			}
			catch(PDOException $e){
			    echo $e->getMessage();
			}
		}

		/* ************************************** */
		/*--- FUNCIONES DE LA PÁGINA PRINCIPAL ---*/
		/* ************************************** */

		/*--- COMPRUEBA SI EL SUSUARIO ENVIADO ES ADMINISTRADOR ---*/
		public function isAdmin($user, $pass){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT Rol FROM Usuario WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $user);
		    $stmt->bindParam(':clave', $pass);

		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
		        if($row['Rol'] == 'admin'){
		        	return true;
		        }else{
		        	return false;
		        }
		    }
		    $con = null;
		}

		/*--- DEVUELVE TODAS LAS ACTUALIZACIONES ORDENADAS ---*/
		public function getUpdates(){
			$updates  = array();
			$con = Modelo::conectar();
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

		/* *************************** */
		/*---FUNCIONES DE PINTORES ---*/
		/* ************************* */

		/*--- DEVUELVE TODOS LOS PINTORES ---*/
		public function getPintores(){
			$pintores = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor ORDER BY nombrePintor ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
				$pintores[] = $pintor;
		    }
		    return $pintores;
			$con = null;
		}

		/*--- DEVUELVE PINTOR CON ID INDICADA ---*/
		public function getPintorPorId($idPintor){
			$pintores = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor WHERE idPintor = :idPintor");

		    $stmt->bindParam(':idPintor', $idPintor);

		    $stmt->execute();
		    $result = $stmt->fetchAll();

			foreach($result as $row){
				$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
				$pintores[] = $pintor;
		    }
		    return $pintores;
			$con = null;
		}

		/*--- MODIFICA UN PINTOR ---*/
		public function modificaPintor($pintor){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Pintor SET nombrePintor = :nombrep,  bioPintor = :biop, fechaNacimiento = :fechan, fechaMuerte = :fecham, fotoPintor = :fotop WHERE idPintor = :idp");
			
			$stmt->bindParam(':idp', $pintor['idPintor']);
			$stmt->bindParam(':nombrep', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $pintor['bioPintor']);
			$stmt->bindParam(':fechan', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fecham', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $pintor['fotoPintor']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		/* *************************** */
		/*--- FUNCIONES DE CUADROS ---*/
		/* ************************* */

		/*---DEVUELVE TODOS LOS CUADROS ---*/
		public function getCuadros(){
			$cuadros = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Cuadros ORDER BY nombreCuadro ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$cuadro = new Cuadro($row['idCuadro'],$row['idPintor'],$row['idExposicion'],$row['idEstilo'],$row['nombreCuadro'],$row['descripcionCuadro'],$row['fotoCuadro']);
				$cuadros[] = $cuadro;
		    }
		    return $cuadros;
			$con = null;
		}
	}
?>