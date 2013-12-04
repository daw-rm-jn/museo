<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';
	require_once 'Model_Pintores.php';
	require_once 'Model_Exposiciones.php';
	require_once 'Model_Estilos.php';

	class Model_Cuadros{
		static function getDatosCuadro($id){
			$idCuadro = Model_Cuadros::getIdCuadro($id);
			$idPintor = Model_Cuadros::getIdPintorCuadro($id);
			$idExposicion = Model_Cuadros::getIdExposicionCuadro($id);
			$idEstilo = Model_Cuadros::getIdEstiloCuadro($id);
			$nombreCuadro = Model_Cuadros::getNombreCuadro($id);
			$descripcionCuadro = Model_Cuadros::getDescCuadro($id);
			$fotoCuadro = Model_Cuadros::getFotoCuadro($id);

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
				$cuadro = new Cuadro($row['idCuadro'],$row['idPintor'],$row['idExposicion'],$row['idEstilo'],$row['nombreCuadro'],$row['descripcionCuadro'],$row['fotoCuadro']);
				$cuadros[] = $cuadro;
		    }
		    return $cuadros;
			$con = null;
		}

		static function addCuadro($cuadro, $descriptor){
			$idp = Model_Pintores::getIdPintor($descriptor['pintor']);
			$idex = Model_Exposiciones::getIdExposicion($descriptor['expo']);
			$ides = Model_Estilos::getIdEstilo($descriptor['estilo']);
			
			$con = Model_BD::conectar();
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
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function modificaCuadro($cuadro, $descriptor){
			$idp = Model_Pintores::getIdPintor($descriptor['pintor']);
			$idex = Model_Exposiciones::getIdExposicion($descriptor['expo']);
			$ides = Model_Estilos::getIdEstilo($descriptor['estilo']);

			$con = Model_BD::conectar();
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
					'op' => 'MODIFICACIÓN [CUADRO]',
					'sec' => 'Pintor',
					'id' => $descriptor['id'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
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

				/*$cuadroABorrar = Modelo::getCuadroPorId($idCuadros[$i]);
				$nombreCuadro = $cuadroABorrar->getnombreCuadro();*/

				//Modelo::borraDirectorio(__DIR__.'/../../img/cuadros/'.$nombreCuadro.'/');

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [CUADRO]',
						'sec' => 'Cuadro',
						'id' => $idCuadros[$i],
						'estado' => 'eliminado'
					);
					Model_Misc::insertUpdate($descriptor);
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