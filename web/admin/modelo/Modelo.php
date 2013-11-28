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
		static function isAdmin($datos){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Administrador WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $datos['Usuario']);
		    $stmt->bindParam(':clave', $datos['Clave']);

		    $stmt->execute();
		    $result = $stmt->fetch();
			$affected_rows = $stmt->rowCount();
		    
	        if($affected_rows >= 0){
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

		static function insertUpdate($descriptor){
			$con = Modelo::conectar();
			$update = $con->prepare("INSERT INTO Actualizacion (tituloActualizacion, fechaActualizacion, descActualizacion, Usuario_email) VALUES (:op, NOW(), 'El registro de tipo " . $descriptor['sec'] . " con id #" . $descriptor['id'] . " ha sido " . $descriptor['estado'] ."', :user)");

			$update->bindParam(':op', $descriptor['op']);
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
			$stmt = $con->prepare("SELECT * FROM Pintor ORDER BY idPintor ASC");
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
		static function modificaPintor($pintor, $descriptor){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Pintor SET nombrePintor = :nombrep,  bioPintor = :biop, fechaNacimiento = :fechan, fechaMuerte = :fecham, fotoPintor = :fotop WHERE idPintor = :idp");
			
			$stmt->bindParam(':idp', $pintor['idPintor']);
			$stmt->bindParam(':nombrep', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $descriptor['bio']);
			$stmt->bindParam(':fechan', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fecham', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [PINTOR]',
					'sec' => 'Pintor',
					'id' => $pintor['idPintor'],
					'estado' => 'actualizado'
				);
				Modelo::insertUpdate($descriptor);
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

				//Modelo::borraDirectorio(__DIR__.'/../../img/pintores/'. $nombrePintor);

				$descriptor = array(
					'op' => 'BAJA [PINTOR]',
					'sec' => 'Pintor',
					'id' => $idPintores[$i],
					'estado' => 'eliminado'
				);
				Modelo::insertUpdate($descriptor);

			}
			$con = null;
		}

		/*--- AÑADE UN PINTOR ---*/
		static function addPintor($pintor, $descriptor){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Pintor (nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (:nomp,:biop,:fechn,:fechm,:fotop)");

			$stmt->bindParam(':nomp', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $descriptor['bio']);
			$stmt->bindParam(':fechn', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fechm', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [PINTOR]',
					'sec' => 'Pintor',
					'id' => $con->lastInsertId(),
					'estado' => 'insertado'
				);
				Modelo::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

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
			$stmt = $con->prepare("SELECT * FROM Estilo ORDER BY idEstilo ASC");
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
				$descriptor = array(
					'op' => 'MODIFICACIÓN [ESTILO]',
					'sec' => 'Estilo',
					'id' => $estilo['idEstilo'],
					'estado' => 'actualizado'
				);
				Modelo::insertUpdate($descriptor);
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

				$descriptor = array(
					'op' => 'BAJA [ESTILO]',
					'sec' => 'Estilo',
					'id' => $idEstilos[$i],
					'estado' => 'eliminado'
				);
				Modelo::insertUpdate($descriptor);

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
				$descriptor = array(
					'op' => 'ALTA [ESTILO]',
					'sec' => 'Estilo',
					'id' => $con->lastInsertId(),
					'estado' => 'insertado'
				);
				Modelo::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		/*--- DEVUELVE LA ID DE UN ESTILO ---*/
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

		/*--- DEVUELVE CUADRO CON ID INDICADA ---*/
		static function getDatosCuadro($id){
			$idCuadro = Modelo:: getIdCuadro($id);
			$idPintor = Modelo:: getIdPintorCuadro($id);
			$idExposicion = Modelo:: getIdExposicionCuadro($id);
			$idEstilo = Modelo:: getIdEstiloCuadro($id);
			$nombreCuadro = Modelo:: getNombreCuadro($id);
			$descripcionCuadro = Modelo:: getDescCuadro($id);
			$fotoCuadro = Modelo:: getFotoCuadro($id);

			$datosCuadro = array(
				'idCuadro' => $idCuadro,
				'idPintor' => $idPintor,
				'idExposicion' => $idExposicion,
				'idEstilo' => $idEstilo,
				'nombreCuadro' => $nombreCuadro,
				'descripcionCuadro' => $descripcionCuadro,
				'fotoCuadro' => $fotoCuadro
			);

			return $datosCuadro;
		}

		static function getDescCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT descripcionCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$descripcionCuadro = $row['descripcionCuadro'];
			
		    return $descripcionCuadro;
			$con = null;
		}

		static function getNombreCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombreCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$nombreCuadro = $row['nombreCuadro'];
			
		    return $nombreCuadro;
			$con = null;
		}

		static function getIdEstiloCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idEstilo FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idEstilo = $row['idEstilo'];
			
		    return $idEstilo;
			$con = null;
		}

		static function getIdExposicionCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idExposicion FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idExposicion = $row['idExposicion'];
			
		    return $idExposicion;
			$con = null;
		}

		static function getIdPintorCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idPintor FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idPintor = $row['idPintor'];
			
		    return $idPintor;
			$con = null;
		}

		static function getIdCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idCuadro = $row['idCuadro'];
			
		    return $idCuadro;
			$con = null;
		}

		static function getFotoCuadro($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT fotoCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$fotoCuadro = $row['fotoCuadro'];
			
		    return $fotoCuadro;
			$con = null;
		}

		/*--- DEVUELVE TODOS LOS CUADROS ---*/
		static function getCuadros(){
			$cuadros = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Cuadro ORDER BY idCuadro ASC");
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
		static function addCuadro($cuadro, $descriptor){
			$idp = Modelo::getIdPintor($descriptor['pintor']);
			$idex = Modelo::getIdExposicion($descriptor['expo']);
			$ides = Modelo::getIdEstilo($descriptor['estilo']);
			
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Cuadro (idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,fotoCuadro) VALUES (:idp,:idex,:ides,:nomc,:descc,:fotoc)");

			$stmt->bindParam(':nomc', $cuadro['nombreCuadro']);
			$stmt->bindParam(':descc', $descriptor['descripcion']);
			$stmt->bindParam(':fotoc', $descriptor['foto']);
			$stmt->bindParam(':idp', $idp);
			$stmt->bindParam(':idex', $idex);
			$stmt->bindParam(':ides', $ides);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [CUADRO]',
					'sec' => 'Cuadro',
					'id' => $con->lastInsertId(),
					'estado' => 'insertado'
				);
				Modelo::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		/*--- MODIFICA UN CUADRO ---*/
		static function modificaCuadro($cuadro, $descriptor){
			$idp = Modelo::getIdPintor($descriptor['pintor']);
			$idex = Modelo::getIdExposicion($descriptor['expo']);
			$ides = Modelo::getIdEstilo($descriptor['estilo']);

			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Cuadro SET idPintor = :idp, idEstilo = :ides, idExposicion = :idex, nombreCuadro = :nomc, descripcionCuadro = :descc, fotoCuadro = :fotoc WHERE idCuadro = :idc");
			
			$stmt->bindParam(':nomc', $cuadro['nombreCuadro']);
			$stmt->bindParam(':descc', $descriptor['descripcion']);
			$stmt->bindParam(':fotoc', $descriptor['foto']);
			$stmt->bindParam(':idc', $descriptor['id']);
			$stmt->bindParam(':idp', $idp);
			$stmt->bindParam(':idex', $idex);
			$stmt->bindParam(':ides', $ides);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [PINTOR]',
					'sec' => 'Pintor',
					'id' => $descriptor['id'],
					'estado' => 'actualizado'
				);
				Modelo::insertUpdate($descriptor);
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

		/*--- ELIMINA UNO O MAS CUADROS ---*/
		static function borrarCuadros($idCuadros){
			$con = Modelo::conectar();
			for ($i=0; $i < sizeof($idCuadros); $i++) { 
				$stmt = $con->prepare("DELETE FROM Cuadro WHERE idCuadro = :id");
				$stmt->bindParam(':id', $idCuadros[$i]);
				$stmt->execute();

				$cuadroABorrar = Modelo::getCuadroPorId($idCuadros[$i]);
				$nombreCuadro = $cuadroABorrar->getnombreCuadro();

				//Modelo::borraDirectorio(__DIR__.'/../../img/cuadros/'.$nombreCuadro.'/');

				$descriptor = array(
					'op' => 'BAJA [PINTOR]',
					'sec' => 'Cuadro',
					'id' => $idCuadros[$i],
					'estado' => 'eliminado'
				);
				Modelo::insertUpdate($descriptor);

			}
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
		static function getExposiciones(){
			$exposiciones = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Exposicion ORDER BY idExposicion ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$exposicion = new Exposicion($row['idExposicion'],$row['idSala'],$row['nombreExposicion'],$row['fechaInicio'],$row['fechaFIn'],$row['descripcionExpo']);
				$exposiciones[] = $exposicion;
		    }
		    return $exposiciones;
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