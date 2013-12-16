<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';
	require_once 'Model_Pintores.php';
	require_once 'Model_Museo.php';
	require_once 'Model_Estilos.php';

	class Model_Cuadros{
		static function getDatosCuadro($id){
			$idCuadro = Model_Cuadros::getIdCuadro($id);
			$idPintor = Model_Cuadros::getIdPintorCuadro($id);
			$idExposicion = Model_Cuadros::getIdExposicionCuadro($id);
			$idEstilo = Model_Cuadros::getIdEstiloCuadro($id);
			$nombreCuadro = Model_Cuadros::getNombreCuadro($id);
			$descripcionCuadro = Model_Cuadros::getDescCuadro($id);
			$orientacion = Model_Cuadros::getOrientacionCuadro($id);
			$anioCuadro = Model_Cuadros::getAnioCuadro($id);
			$fotoCuadro = Model_Cuadros::getFotoCuadro($id);

			$datosCuadro = array(
				'idCuadro' => $idCuadro,
				'idPintor' => $idPintor,
				'idExposicion' => $idExposicion,
				'idEstilo' => $idEstilo,
				'nombreCuadro' => $nombreCuadro,
				'descripcionCuadro' => $descripcionCuadro,
				'orientacion' => $orientacion,
				'anioCuadro' => $anioCuadro,
				'fotoCuadro' => $fotoCuadro
			);

			return $datosCuadro;
		}

		static function getAnioCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT anioCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$anioCuadro = $row['anioCuadro'];
			
		    return $anioCuadro;
			$con = null;
		}

		static function getOrientacionCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT orientacion FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$orientacion = $row['orientacion'];
			
		    return $orientacion;
			$con = null;
		}

		static function getDescCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT descripcionCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$descripcionCuadro = $row['descripcionCuadro'];
			
		    return $descripcionCuadro;
			$con = null;
		}

		static function getNombreCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT nombreCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$nombreCuadro = $row['nombreCuadro'];
			
		    return $nombreCuadro;
			$con = null;
		}

		static function getIdEstiloCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idEstilo FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idEstilo = $row['idEstilo'];
			
		    return $idEstilo;
			$con = null;
		}

		static function getIdExposicionCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idExposicion FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idExposicion = $row['idExposicion'];
			
		    return $idExposicion;
			$con = null;
		}

		static function getIdPintorCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idPintor FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idPintor = $row['idPintor'];
			
		    return $idPintor;
			$con = null;
		}

		static function getIdCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$idCuadro = $row['idCuadro'];
			
		    return $idCuadro;
			$con = null;
		}

		static function getFotoCuadro($id){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT fotoCuadro FROM Cuadro WHERE idCuadro = :idCuadro");

		    $stmt->bindParam(':idCuadro', $id);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$fotoCuadro = $row['fotoCuadro'];
			
		    return $fotoCuadro;
			$con = null;
		}

		static function getCuadros(){
			$cuadros = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Cuadro ORDER BY idCuadro ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$cuadro = new Cuadro($row['idCuadro'],$row['idPintor'],$row['idExposicion'],$row['idEstilo'],$row['nombreCuadro'],$row['descripcionCuadro'],$row['orientacion'],$row['anioCuadro'],$row['fotoCuadro']);
				$cuadros[] = $cuadro;
		    }
		    return $cuadros;
			$con = null;
		}

		static function addCuadro($cuadro, $descriptor){			
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Cuadro (idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,orientacion,anioCuadro,fotoCuadro) VALUES (:idp,:idex,:ides,:nomc,:descc,:orc,:anioc,:fotoc)");

			$stmt->bindParam(':nomc', $cuadro['nombreCuadro']);
			$stmt->bindParam(':orc', $cuadro['orientacion']);
			$stmt->bindParam(':anioc', $cuadro['anioCuadro']);
			$stmt->bindParam(':descc', $descriptor['descripcion']);
			$stmt->bindParam(':fotoc', $descriptor['foto']);
			$stmt->bindParam(':idp', $descriptor['pintor']);
			$stmt->bindParam(':idex', $descriptor['expo']);
			$stmt->bindParam(':ides', $descriptor['estilo']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [CUADRO]',
						'descripcion' => 'Se ha insertado el registro Cuadro con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function modificaCuadro($cuadro, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Cuadro SET idPintor = :idp, idEstilo = :ides, idExposicion = :idex, nombreCuadro = :nomc, descripcionCuadro = :descc, orientacion = :orc, anioCuadro = :anioc, fotoCuadro = :fotoc WHERE idCuadro = :idc");
			
			$stmt->bindParam(':nomc', $cuadro['nombreCuadro']);
			$stmt->bindParam(':orc', $cuadro['orientacion']);
			$stmt->bindParam(':anioc', $cuadro['anioCuadro']);
			$stmt->bindParam(':descc', $descriptor['descripcion']);
			$stmt->bindParam(':fotoc', $descriptor['foto']);
			$stmt->bindParam(':idc', $descriptor['id']);
			$stmt->bindParam(':idp', $descriptor['pintor']);
			$stmt->bindParam(':idex', $descriptor['expo']);
			$stmt->bindParam(':ides', $descriptor['estilo']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
					$act = array(
						'titulo' => 'MODIFICACION [CUADRO]',
						'descripcion' => 'Se ha modificado el registro Cuadro con id ' . $descriptor['id'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		static function getPintordeCuadro($idPintorCuadro){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT nombrePintor FROM Pintor WHERE idPintor = :idpc");

			$stmt->bindParam (':idpc', $idPintorCuadro);

			$stmt->execute();
		    $row = $stmt->fetch();

		    $nombrePintor = $row['nombrePintor'];

		    return $nombrePintor;		    
			$con = null;
		}

		static function borrarCuadros($idCuadros){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idCuadros); $i++) { 
				$stmt = $con->prepare("DELETE FROM Cuadro WHERE idCuadro = :id");
				$stmt->bindParam(':id', $idCuadros[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$act = array(
						'titulo' => 'BAJA [CUADRO]',
						'descripcion' => 'Se ha borrado el registro Cuadro con id '. $idCuadros[$i] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getEstilodeCuadro($idEstiloCuadro){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT nombreEstilo FROM Estilo WHERE idEstilo = :idec");

			$stmt->bindParam (':idec', $idEstiloCuadro);

			$stmt->execute();
		    $row = $stmt->fetch();

		    $nombreEstilo = $row['nombreEstilo'];

		    return $nombreEstilo;		    
			$con = null;

		}
	}
?>