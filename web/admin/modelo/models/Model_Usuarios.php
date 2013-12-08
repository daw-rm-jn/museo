<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Usuarios{
		static function getClientes(){
			$users = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Usuario ORDER BY email ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$user = new Usuario($row['email'],$row['clave'],$row['nombre'],$row['nif'],$row['dir'],$row['cp'],$row['telf'],$row['fechaAlta']);
				$users[] = $user;
		    }
		    return $users;
			$con = null;
		}

		static function getDatosBancarios($cliente){
			$users = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT numeroTarjeta,CCV,fechaCaducidad FROM Datos_Bancarios WHERE email = :email");

			$stmt->bindParam(':email', $cliente->getemail());

		    $stmt->execute();
		    $row = $stmt->fetch();

			$datos = array(
				'numeroTarjeta' => $row['numeroTarjeta'],
				'CCV' => $row['CCV'],
				'fechaCaducidad' => $row['fechaCaducidad']
			);
			
		    return $datos;
			$con = null;
		}

		static function addCliente($cliente){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Usuario (email,clave,nombre,nif,dir,cp,telf,fechaAlta) VALUES (:email,:clave,:nombre,:nif,:dir,:cp,:telf,NOW())");
			$insertdatosbanc = $con->prepare("INSERT INTO Datos_Bancarios VALUES (:emaildb,:numt,:ccvt,:fechacadt)");

			$stmt->bindParam(':email', $cliente['email']);
			$stmt->bindParam(':clave', $cliente['clave']);
			$stmt->bindParam(':nombre', $cliente['nombre']);
			$stmt->bindParam(':nif', $cliente['nif']);
			$stmt->bindParam(':dir', $cliente['dir']);
			$stmt->bindParam(':cp', $cliente['cp']);
			$stmt->bindParam(':telf', $cliente['telf']);

			$insertdatosbanc->bindParam(':emaildb', $cliente['email']);
			$insertdatosbanc->bindParam(':numt', $cliente['numeroTarjeta']);
			$insertdatosbanc->bindParam(':ccvt', $cliente['CCV']);
			$insertdatosbanc->bindParam(':fechacadt', $cliente['fechaCaducidad']);

			$stmt->execute();
			$insertdatosbanc->execute();

			$affected_rows_datosbanc = $insertdatosbanc->rowCount();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0 && $affected_rows_datosbanc >= 0){
				$descriptor = array(
					'op' => 'ALTA [CLIENTE]',
					'sec' => 'Cliente',
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

		static function borrarClientes($emailClientes){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($emailClientes); $i++) { 
				$stmt = $con->prepare("DELETE FROM Usuario WHERE email = :email");
				$stmt->bindParam(':email', $emailClientes[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [PINTOR]',
						'sec' => 'Pintor',
						'id' => $emailClientes[$i],
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

		static function getClientePorId($email){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Usuario WHERE email = :email");

		    $stmt->bindParam(':email', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$user = new Usuario($row['email'],$row['clave'],$row['nombre'],$row['nif'],$row['dir'],$row['cp'],$row['telf'],$row['fechaAlta']);
			
		    return $user;
			$con = null;
		}

		static function modificaCliente($cliente){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Usuario SET clave = :clave, nombre = :nombre, nif = :nif, dir = :dir, cp = :cp, telf = :telf WHERE email = :email");
			$updatedatosbanc = $con->prepare("UPDATE Datos_Bancarios SET numeroTarjeta = :numt, CCV = :ccvt, fechaCaducidad = :fechcadt WHERE email = :emaildb");
			
			$stmt->bindParam(':email', $cliente['email']);
			$stmt->bindParam(':clave', $cliente['clave']);
			$stmt->bindParam(':nombre', $cliente['nombre']);
			$stmt->bindParam(':nif', $cliente['nif']);
			$stmt->bindParam(':dir', $cliente['dir']);
			$stmt->bindParam(':cp', $cliente['cp']);
			$stmt->bindParam(':telf', $cliente['telf']);

			$updatedatosbanc->bindParam(':emaildb', $cliente['email']);
			$updatedatosbanc->bindParam(':numt', $cliente['numeroTarjeta']);
			$updatedatosbanc->bindParam(':ccvt', $cliente['CCV']);
			$updatedatosbanc->bindParam(':fechcadt', $cliente['fechaCaducidad']);

			$stmt->execute();
			$updatedatosbanc->execute();

			$affected_rows_datosbanc = $updatedatosbanc->rowCount();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0 && $affected_rows_datosbanc >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [CLIENTE]',
					'sec' => 'Cliente',
					'id' => $cliente['email'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getAdmins(){
			$admins = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Administrador ORDER BY email ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$admin = new Admin($row['email'],$row['clave'],$row['fechaAlta']);
				$admins[] = $admin;
		    }
		    return $admins;
			$con = null;
		}

		static function addAdmin($admin){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Administrador (email,clave,fechaAlta) VALUES (:email,:clave,NOW())");

			$stmt->bindParam(':email', $admin['email']);
			$stmt->bindParam(':clave', $admin['clave']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [ADMIN]',
					'sec' => 'Administrador',
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

		static function borrarAdmins($emailAdmins){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($emailAdmins); $i++) { 
				$stmt = $con->prepare("DELETE FROM Administrador WHERE email = :email");
				$stmt->bindParam(':email', $emailAdmins[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [ADMIN]',
						'sec' => 'Administrador',
						'id' => $emailAdmins[$i],
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

		static function getAdminPorId($email){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Administrador WHERE email = :email");

		    $stmt->bindParam(':email', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$admin = new Admin($row['email'],$row['clave'],$row['fechaAlta']);
			
		    return $admin;
			$con = null;
		}

		static function modificaAdmin($admin){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Administrador SET clave = :clave WHERE email = :email");
						
			$stmt->bindParam(':clave', $admin['clave']);
			$stmt->bindParam(':email', $admin['email']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [ADMIN]',
					'sec' => 'Administrador',
					'id' => $admin['email'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}
	}
?>