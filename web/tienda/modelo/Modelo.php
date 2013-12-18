<?php 
	require 'ListaClases.php';

	class Modelo{
		static function conectar(){
			$host = 'localhost';
			$usuario = 'root';
			$clave = 'root';

			try {
			    $con = new PDO("mysql:host=$host;dbname=bd_Museo;charset=utf8", $usuario, $clave);
			    return $con;
			}catch(PDOException $e){
			    echo $e->getMessage();
			}
		}

		static function getUltimosProductos(){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro ORDER BY fechaAlta ASC LIMIT 6");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }
		    return $productos;
			$con = null;
		}

		static function isCliente($datos){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Usuario WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $datos['usuario']);
		    $stmt->bindParam(':clave', $datos['clavecifrada']);

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

		static function getDatosCliente($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Usuario WHERE email = :email");

			$stmt->bindParam(':email', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$cliente = new Usuario($row['email'],$row['clave'],$row['nombre'],$row['nif'],$row['dir'],$row['cp'],$row['telf'],$row['fechaAlta']);

		    return $cliente;

		    $con = null;
		}

		static function getDatosBanc($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Datos_Bancarios WHERE email = :email");

			$stmt->bindParam(':email', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$affected_rows = $stmt->rowCount();

			if($row != null){
				$datosBanc = array(
					'numeroTarjeta' => $row['numeroTarjeta'],
					'CCV' => $row['CCV'],
					'fechaCaducidad' => $row['fechaCaducidad']
				);
			    return $datosBanc;
			}else{
				return null;
			}

		    $con = null;
		}

		static function getNombreCliente($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT nombre FROM Usuario WHERE email = :usuario");

		    $stmt->bindParam(':usuario', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$nombreCliente = $row['nombre'];
			
		    return $nombreCliente;

		    $con = null;
		}

		static function getClaveCliente($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT clave FROM Usuario WHERE email = :usuario");

		    $stmt->bindParam(':usuario', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$claveCliente = $row['clave'];
			
		    return $claveCliente;

		    $con = null;
		}

		static function registroCliente($cliente,$fechaCad){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Usuario (email,clave,nombre,nif,dir,cp,telf,fechaAlta) VALUES (:email,:clave,:nombre,:nif,:dir,:cp,:telf,NOW())");

			$stmt->bindParam(':email', $cliente['email']);
			$stmt->bindParam(':clave', $cliente['clavecifrada']);
			$stmt->bindParam(':nombre', $cliente['nombre']);
			$stmt->bindParam(':nif', $cliente['nif']);
			$stmt->bindParam(':dir', $cliente['direccion']);
			$stmt->bindParam(':cp', $cliente['codigoPostal']);
			$stmt->bindParam(':telf', $cliente['telf']);

			$stmt->execute();	
			$affected_rows = $stmt->rowCount();

			if($cliente['numeroTarjeta'] != "" && $cliente['CCV'] != "" && $fechaCad != "" ){
				$datosBanc = array(
					'email' => $cliente['email'],
					'numeroTarjeta' => $cliente['numeroTarjeta'],
					'CCV' => $cliente['CCV'],
					'fechaCad' => $fechaCad
				);
				Modelo::addDatosBancarios($datosBanc);
			}

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function addDatosBancarios($datosBanc){
			$con = Modelo::conectar();
			$insertdatosbanc = $con->prepare("INSERT INTO Datos_Bancarios VALUES (:emaildb,:numt,:ccvt,:fechacadt)");

			$insertdatosbanc->bindParam(':emaildb', $datosBanc['email']);
			$insertdatosbanc->bindParam(':numt', $datosBanc['numeroTarjeta']);
			$insertdatosbanc->bindParam(':ccvt', $datosBanc['CCV']);
			$insertdatosbanc->bindParam(':fechacadt', $datosBanc['fechaCad']);

			$insertdatosbanc->execute();

			$affected_rows_datosbanc = $insertdatosbanc->rowCount();

			$con  = null;
		}
		static function modificaCuenta($cliente,$fechaCad){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Usuario SET clave = :clave,nombre = :nombre,nif = :nif,dir = :dir,cp = :cp,telf = :telf WHERE email = :email");

			if($cliente['claveactualcifrada'] == Modelo::getClaveCliente($cliente['email'])){
				if($cliente['clavenuevacifrada'] != ""){
					$stmt->bindParam(':clave', $cliente['clavenuevacifrada']);
				}else{
					$stmt->bindParam(':clave', $cliente['claveactualcifrada']);
				}
			}else{
				return false;
			}
			
			$stmt->bindParam(':email', $cliente['email']);
			$stmt->bindParam(':nombre', $cliente['nombre']);
			$stmt->bindParam(':nif', $cliente['nif']);
			$stmt->bindParam(':dir', $cliente['direccion']);
			$stmt->bindParam(':cp', $cliente['codigoPostal']);
			$stmt->bindParam(':telf', $cliente['telf']);

			$stmt->execute();	
			$affected_rows = $stmt->rowCount();

			if($cliente['numeroTarjeta'] != "" && $cliente['CCV'] != "" && $fechaCad != "" ){
				$datosBanc = array(
					'email' => $cliente['email'],
					'numeroTarjeta' => $cliente['numeroTarjeta'],
					'CCV' => $cliente['CCV'],
					'fechaCad' => $fechaCad
				);
				if(Modelo::getDatosBanc($cliente['email']) != null){
					Modelo::modificaDatosBancarios($datosBanc);	
				}else{
					Modelo::addDatosBancarios($datosBanc);
				}
				
			}

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}

			$con = null;			
		}

		static function modificaDatosBancarios($datosBanc){
			$con = Modelo::conectar();
			$moddatosbanc = $con->prepare("UPDATE Datos_Bancarios SET numeroTarjeta = :numt,CCV = :ccvt,fechaCaducidad = :fechacadt WHERE email = :emaildb");

			$moddatosbanc->bindParam(':emaildb', $datosBanc['email']);
			$moddatosbanc->bindParam(':numt', $datosBanc['numeroTarjeta']);
			$moddatosbanc->bindParam(':ccvt', $datosBanc['CCV']);
			$moddatosbanc->bindParam(':fechacadt', $datosBanc['fechaCad']);

			$moddatosbanc->execute();

			$affected_rows_datosbanc = $moddatosbanc->rowCount();

			$con  = null;
		}

		static function borrarCuenta($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("DELETE FROM Usuario WHERE email = :email");
			$borraDatosBanc = $con->prepare("DELETE FROM Datos_Bancarios WHERE email = :emaildb");

			$stmt->bindParam(':email', $email);
			$borraDatosBanc->bindParam(':emaildb', $email);

			$stmt->execute();
			$borraDatosBanc->execute();

			$con = null;
		}
	}
?>