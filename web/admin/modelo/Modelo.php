<?php 
	require 'ListaModelos.php';

	class Modelo{

		/*--- CONEXIÓN A LA BBDD---*/
		static function conectar(){
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

		/*-----------------------------------------*/
		/*--- FUNCIONES DE LA PÁGINA PRINCIPAL ---*/
		/*---------------------------------------*/

		/*--- COMPRUEBA SI EL SUSUARIO ENVIADO ES ADMINISTRADOR ---*/
		static function isAdmin($user, $pass){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT Rol FROM Usuario WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $user);
		    $stmt->bindParam(':clave', $pass);

		    $stmt->execute();
		    $row = $stmt->fetch();
		    
	        if($row['Rol'] == 'admin'){
	        	return true;
	        }else{
	        	return false;
	        }
		    $con = null;
		}

		/*--- DEVUELVE TODAS LAS ACTUALIZACIONES ORDENADAS ---*/
		static function getUpdates(){
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

		static function insertUpdate($op, $sec, $id, $estado){
			$con = Modelo::conectar();
			$update = $con->prepare("INSERT INTO Actualizacion (tituloActualizacion, fechaActualizacion, descActualizacion, Usuario_email) VALUES (:op, NOW(), 'El registro de tipo " . $sec . " con id #" . $id . " ha sido " . $estado ."', :user)");

			$update->bindParam(':op', $op);
			$update->bindParam(':user', $_SESSION['admin']);

			$update->execute();
			$affected_rows = $update->rowCount();

			$con = null;
		}

		/*-----------------------------*/
		/*---FUNCIONES DE PINTORES ---*/
		/*---------------------------*/

		/*--- DEVUELVE TODOS LOS PINTORES ---*/
		static function getPintores(){
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
		static function getPintorPorId($idPintor){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor WHERE idPintor = :idPintor");

		    $stmt->bindParam(':idPintor', $idPintor);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
			
		    return $pintor;
			$con = null;
		}

		/*--- MODIFICA UN PINTOR ---*/
		static function modificaPintor($pintor, $bio, $foto){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Pintor SET nombrePintor = :nombrep,  bioPintor = :biop, fechaNacimiento = :fechan, fechaMuerte = :fecham, fotoPintor = :fotop WHERE idPintor = :idp");
			
			$stmt->bindParam(':idp', $pintor['idPintor']);
			$stmt->bindParam(':nombrep', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $bio);
			$stmt->bindParam(':fechan', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fecham', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $foto);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				Modelo::insertUpdate('MODIFICACIÓN [PINTOR]', 'Pintor', $pintor['idPintor'], 'actualizado');
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		/*--- ELIMINA UNO O MAS PINTORES ---*/
		static function borrarPintores($idPintores){
			$con = Modelo::conectar();
			for ($i=0; $i < sizeof($idPintores); $i++) { 
				$stmt = $con->prepare("DELETE FROM Pintor WHERE idPintor = :id");
				$stmt->bindParam(':id', $idPintores[$i]);
				$stmt->execute();

				$pintorABorrar = Modelo::getPintorPorId($idPintores[$i]);
				$nombrePintor = $pintorABorrar->getnombrePintor();

				Modelo::borraDirectorio(__DIR__.'/../img/'. $nombrePintor);

				Modelo::insertUpdate('BAJA [PINTOR]', 'Pintor', $idPintores[$i], 'eliminado');

			}
			$con = null;
		}

		/*--- AÑADE UN PINTOR ---*/
		static function addPintor($pintor, $bio, $foto){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Pintor (nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (:nomp,:biop,:fechn,:fechm,:fotop)");

			$stmt->bindParam(':nomp', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $bio);
			$stmt->bindParam(':fechn', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fechm', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $foto);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				Modelo::insertUpdate('ALTA [PINTOR]', 'Pintor', $con->lastInsertId(), 'insertado');
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		/*--- DEVUELVE LOS NOMBRES DE TODOS LOS PINTORES ---*/
		static function getNombresDePintores(){
			$nombres = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombrePintor FROM Pintor");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$nombre = $row['nombrePintor'];
				$nombres[] = $nombre;
		    }
		    return $nombres;
			$con = null;
		}

		/*--- DEVULVE LA ID DE UN PINTOR ---*/
		static function getIdPintor($nombre){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idPintor FROM Pintor WHERE nombrePintor = :nombrePintor");

		    $stmt->bindParam(':nombrePintor', $nombre);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$id = $row['idPintor'];
			
		    return $id;
			$con = null;
		}

		/*-----------------------------*/
		/*--- FUNCIONES DE ESTILOS ---*/
		/*---------------------------*/

		/*--- DEVUELVE TODOS LOS ESTILOS ---*/
		static function getEstilos(){
			$estilos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Estilo ORDER BY nombreEstilo ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$estilo = new Estilo($row['idEstilo'],$row['nombreEstilo'],$row['descripcionEstilo']);
				$estilos[] = $estilo;
		    }
		    return $estilos;
			$con = null;
		}

		/*--- DEVUELVE ESTILO POR ID ---*/
		static function getEstiloPorId($idEstilo){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Estilo WHERE idEstilo = :idEstilo");

		    $stmt->bindParam(':idEstilo', $idEstilo);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$estilo = new Estilo($row['idEstilo'],$row['nombreEstilo'],$row['descripcionEstilo']);
			
		    return $estilo;
			$con = null;
		}

		/*--- MODIFICA UN ESTILO ---*/
		static function modificaEstilo($estilo, $desc){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Estilo SET nombreEstilo = :nomestilo,  descripcionEstilo = :descestilo WHERE idEstilo = :ide");
			
			$stmt->bindParam(':ide', $estilo['idEstilo']);
			$stmt->bindParam(':nomestilo', $estilo['nombreEstilo']);
			$stmt->bindParam(':descestilo', $desc);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				Modelo::insertUpdate('MODIFICACIÓN [ESTILO]', 'Estilo', $estilo['idEstilo'], 'actualizado');
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		/*--- ELIMINA UNO O MAS ESTILOS ---*/
		static function borrarEstilos($idEstilos){
			$con = Modelo::conectar();
			for ($i=0; $i < sizeof($idEstilos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Estilo WHERE idEstilo = :id");
				$stmt->bindParam(':id', $idEstilos[$i]);
				$stmt->execute();

				$estiloABorrar = Modelo::getEstiloPorId($idEstilos[$i]);
				$nombreEstilo = $estiloABorrar->getnombreEstilo();

				Modelo::insertUpdate('BAJA [ESTILO]', 'Estilo', $idEstilos[$i], 'eliminado');

			}
			$con = null;
		}

		/*--- AÑADE UN ESTILO ---*/
		static function addEstilo($estilo, $desc){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Estilo (nombreEstilo,descripcionEstilo) VALUES (:nomestilo,:descestilo)");

			$stmt->bindParam(':nomestilo', $estilo['nombreEstilo']);
			$stmt->bindParam(':descestilo', $desc);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				Modelo::insertUpdate('ALTA [ESTILO]', 'Estilo', $con->lastInsertId(), 'insertado');
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		/*--- DEVUELVE LOS NOMBRES DE LOS ESTILOS ---*/
		static function getNombresDeEstilos(){
			$nombres = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombreEstilo FROM Estilo");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$nombre = $row['nombreEstilo'];
				$nombres[] = $nombre;
		    }
		    return $nombres;
			$con = null;
		}

		/*--- DEVULVE LA ID DE UN ESTILO ---*/
		static function getIdEstilo($nombre){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idEstilo FROM Estilo WHERE nombreEstilo = :nombreEstilo");

		    $stmt->bindParam(':nombreEstilo', $nombre);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$id = $row['idEstilo'];
			
		    return $id;
			$con = null;
		}

		/*-----------------------------*/
		/*--- FUNCIONES DE CUADROS ---*/
		/*---------------------------*/

		/*--- DEVUELVE TODOS LOS CUADROS ---*/
		static function getCuadros(){
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

		/*--- AÑADE UN CUADRO ---*/
		static function addCuadro($cuadro, $foto){
			$idp = Modelo::getIdPintor($cuadro['pintor']);
			$idex = Modelo::getIdExposicion($cuadro['exposicion']);
			$ides = Modelo::getIdEstilo($cuadro['estilo']);
			
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Cuadro (idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,fotoCuadro) VALUES (:idp,:idex,:ides,:nomc,:descc,:fotoc");

			$stmt->bindParam(':nomc', $cuadro['nombreCuadro']);
			$stmt->bindParam(':descc', $cuadro['descripcionCuadro']);
			$stmt->bindParam(':fotoc', $foto);
			$stmt->bindParam(':idp', $idp);
			$stmt->bindParam(':idex', $idex);
			$stmt->bindParam(':ides', $ides);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				Modelo::insertUpdate('ALTA [CUADRO]', 'Cuadro', $con->lastInsertId(), 'insertado');
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		/*--- DEVUELVE EL NOMBRE DE PINTOR DE UN CUADRO ---*/
		static function getPintordeCuadro($idPintorCuadro){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombrePintor FROM Pintor WHERE idPintor = :idpc");

			$stmt->bindParam (':idpc', $idPintorCuadro);

			$stmt->execute();
		    $row = $stmt->fetch();

		    $nombrePintor = $row['nombrePintor'];

		    return $nombrePintor;		    
			$con = null;
		}

		/*--- DEVUELVE EL NOMBRE DE ESTILO DE UN CUADRO ---*/
		static function getEstilodeCuadro($idEstiloCuadro){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombreEstilo FROM Estilo WHERE idEstilo = :idec");

			$stmt->bindParam (':idec', $idEstiloCuadro);

			$stmt->execute();
		    $row = $stmt->fetch();

		    $nombreEstilo = $row['nombreEstilo'];

		    return $nombreEstilo;		    
			$con = null;

		}

		/*------------------------------------------*/
		/*--- FUNCIONES PERTENECIENTES AL MUSEO ---*/
		/*----------------------------------------*/

		/*--- DEVUELVE LOS NOMBRES DE LAS EXPOSICIONES ---*/
		static function getNombresDeExpos(){
			$nombres = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombreExposicion FROM Exposicion");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$nombre = $row['nombreExposicion'];
				$nombres[] = $nombre;
		    }
		    return $nombres;
			$con = null;
		}

		/*--- DEVULVE LA ID DE UNA EXPOSICION ---*/
		static function getIdExposicion($nombre){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idExposicion FROM Exposicion WHERE nombreExposicion = :nombreExposicion");

		    $stmt->bindParam(':nombreExposicion', $nombre);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$id = $row['idExposicion'];
			
		    return $id;
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