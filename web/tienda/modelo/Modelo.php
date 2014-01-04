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

		static function getAllProductos(){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro ORDER BY fechaAlta ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }
		    return $productos;
			$con = null;
		}

		static function getAllPintores(){
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

		static function getPintorByName($nombrePintor, $select){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor WHERE nombrePintor = :nombrePintor");

			$stmt->bindParam(':nombrePintor', $nombrePintor);
			$stmt->execute();

			$row = $stmt->fetch();

			$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);

			return $pintor;
			$con = null;
		}

		static function getCuadrosDePintor($nombrePintor){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro WHERE autor = :nombrePintor");

			$stmt->bindParam(':nombrePintor', $nombrePintor);
			$stmt->execute();

			$result = $stmt->fetchAll();

			foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }

			return $productos;
			$con = null;
		}

		static function getAllEstilos(){
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

		static function getEstiloByName($nombreEstilo){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Estilo WHERE nombreEstilo = :nombreEstilo");

			$stmt->bindParam(':nombreEstilo', $nombreEstilo);
			$stmt->execute();

			$row = $stmt->fetch();

			$estilo = new Estilo($row['idEstilo'],$row['nombreEstilo'],$row['descripcionEstilo']);

			return $estilo;
			$con = null;
		}

		static function getCuadrosDeEstilo($nombreEstilo){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro WHERE estilo = :nombreEstilo");

			$stmt->bindParam(':nombreEstilo', $nombreEstilo);
			$stmt->execute();

			$result = $stmt->fetchAll();

			foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }

			return $productos;
			$con = null;
		}

		static function getAllExpos(){
			$expos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Exposicion ORDER BY nombreExposicion ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$expo = new Exposicion($row['idExposicion'],$row['idSala'],$row['nombreExposicion'],$row['fechaInicio'],$row['fechaFin'],$row['descripcionExpo'],$row['cartel']);
				$expos[] = $expo;
		    }
		    return $expos;
			$con = null;
		}

		static function getExpoByName($nombreExposicion){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Exposicion WHERE nombreExposicion = :nombreExposicion");

			$stmt->bindParam(':nombreExposicion', $nombreExposicion);
			$stmt->execute();

			$row = $stmt->fetch();

			$expo = new Exposicion($row['idExposicion'],$row['idSala'],$row['nombreExposicion'],$row['fechaInicio'],$row['fechaFin'],$row['descripcionExpo'],$row['cartel']);

			return $expo;
			$con = null;
		}

		static function getCuadrosDeExpo($idExpo){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT Copia_Cuadro.*, Cuadro.nombreCuadro FROM Copia_Cuadro, Cuadro  WHERE Copia_Cuadro.nombreProducto = Cuadro.nombreCuadro AND Cuadro.idExposicion = :idExpo");
			
			$stmt->bindParam(':idExpo',$idExpo);
			$stmt->execute();

			$result = $stmt->fetchAll();

			foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
			}

			return $productos;
			$con = null;
		}

		static function busqueda($key){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro WHERE nombreProducto LIKE ? OR autor LIKE ? OR estilo LIKE ?");			
			$stmt->bindValue(1, "%$key%", PDO::PARAM_STR);
			$stmt->bindValue(2, "%$key%", PDO::PARAM_STR);
			$stmt->bindValue(3, "%$key%", PDO::PARAM_STR);

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

		static function existeCliente($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT email FROM Usuario WHERE email = :email");

			$stmt->bindParam(":email",$email);

			$stmt->execute();
			$row = $stmt->fetch();
			$affected_rows = $stmt->rowCount();

			if($affected_rows > 0){
	        	return true;
	        }else{
	        	return false;
	        }
		    $con = null;
		}

		static function generaNuevaPass($email, $length = 11){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
		    }

		    $clavemd5 = md5($randomString);

		    $con = Modelo::conectar();
		    $stmt = $con->prepare("UPDATE Usuario SET clave = :clave WHERE email = :email");

		    $stmt->bindParam(":clave", $clavemd5);
		    $stmt->bindParam(":email",$email);

		    $stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows > 0){
				return $randomString;
			}		    
		}

		static function getDatosCliente($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Usuario WHERE email = :email");

			$stmt->bindParam(':email', $email);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$cliente = new Usuario($row['email'],$row['clave'],$row['nombre'],$row['nif'],$row['dir'],$row['pais'],$row['provincia'],$row['poblacion'],$row['cp'],$row['telf'],$row['fechaAlta']);

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

			$datosBanc = array(
				'numeroTarjeta' => $row['numeroTarjeta'],
				'CCV' => $row['CCV'],
				'fechaCaducidad' => $row['fechaCaducidad']
			);
			return $datosBanc;

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
			$stmt = $con->prepare("INSERT INTO Usuario (email,clave,nombre,nif,dir,pais,provincia,poblacion,cp,telf,fechaAlta) VALUES (:email,:clave,:nombre,:nif,:dir,:pais,:prov,:pob,:cp,:telf,NOW())");

			$stmt->bindParam(':email', $cliente['email']);
			$stmt->bindParam(':clave', $cliente['clavecifrada']);
			$stmt->bindParam(':nombre', $cliente['nombre']);
			$stmt->bindParam(':nif', $cliente['nif']);
			$stmt->bindParam(':dir', $cliente['direccion']);
			$stmt->bindParam(':pais', $cliente['pais']);
			$stmt->bindParam(':prov', $cliente['provincia']);
			$stmt->bindParam(':pob', $cliente['poblacion']);
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

			if($affected_rows > 0){
				Modelo::creaCarrito($cliente['email']);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function creaCarrito($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Carrito (email,fechaCreacion,fechaExpir) VALUES (:email,NOW(),NOW()+INTERVAL 10 DAY)");

			$stmt->bindParam(':email',$email);
			$stmt->execute();

			$con = null;
		}

		static function checkCarrito($email){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Carrito WHERE email = :email");

			$stmt->bindParam(':email',$email);
			$stmt->execute();

		    $row = $stmt->fetch();

			if(empty($row)){
				Modelo::creaCarrito($email);
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

			if($cliente['claveactualcifrada'] != Modelo::getClaveCliente($cliente['email'])){
				return false;
			}else{
				$stmt = $con->prepare("UPDATE Usuario SET clave = :clave,nombre = :nombre,nif = :nif,dir = :dir,pais = :pais,provincia = :prov,poblacion = :pob,cp = :cp,telf = :telf WHERE email = :email");
				
				$stmt->bindParam(':email', $cliente['email']);
				$stmt->bindParam(':clave', $cliente['clavenuevacifrada']);
				$stmt->bindParam(':nombre', $cliente['nombre']);
				$stmt->bindParam(':nif', $cliente['nif']);
				$stmt->bindParam(':dir', $cliente['direccion']);
				$stmt->bindParam(':pais', $cliente['pais']);
				$stmt->bindParam(':prov', $cliente['provincia']);
				$stmt->bindParam(':pob', $cliente['poblacion']);
				$stmt->bindParam(':cp', $cliente['codigoPostal']);
				$stmt->bindParam(':telf', $cliente['telf']);

				$stmt->execute();	
				$affected_rows = $stmt->rowCount();

				$checkVacio = array_filter(Modelo::getDatosBanc($cliente['email']));

				if($cliente['numeroTarjeta'] != "" && $cliente['CCV'] != "" && $fechaCad != "" ){
					$datosBanc = array(
						'email' => $cliente['email'],
						'numeroTarjeta' => $cliente['numeroTarjeta'],
						'CCV' => $cliente['CCV'],
						'fechaCad' => $fechaCad
					);
					if(empty($checkVacio)){
						Modelo::addDatosBancarios($datosBanc);	
					}else{
						Modelo::modificaDatosBancarios($datosBanc);
					}
					
				}

				if($affected_rows >= 0){
					return true;
				}else{
					return false;
				}
			}		

			$con = null;			
		}

		static function modificaDirEnvio($email,$dir){
			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Usuario SET dir = :dir WHERE email = :email");

			$stmt->bindParam(":dir",$dir);
			$stmt->bindParam(":email",$email);

			$stmt->execute();

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

			$borraDatosBanc->execute();
			$stmt->execute();

			$affected_rows = $stmt->rowCount();

			if($affected_rows > 0){
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getDetallesProducto($id){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro WHERE idCopia_Cuadro = :id");

			$stmt->bindParam(":id", $id);

			$stmt->execute();
		    $row = $stmt->fetch();

			$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);

		    return $producto;

		    $con = null;
		}

		static function getLineasCarrito($idCarrito){
			$lineas = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Carrito WHERE idCarrito = :idCarrito ORDER BY idLinea_Carrito ASC");

			$stmt->bindParam(':idCarrito',$idCarrito);

		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$linea = array(
					'idLinea_Carrito' => $row['idLinea_Carrito'],
					'idCarrito' => $row['idCarrito'],
					'idCopia_Cuadro' => $row['idCopia_Cuadro'],
					'nombreProducto' => $row['nombreProducto'],
					'unidades' => $row['unidades'],
					'precio' => $row['precio'],
					'IVA' => $row['IVA'],
					'totalLinea' => $row['totalLinea']
				);
				$lineas[] = $linea;
		    }
		    return $lineas;
			$con = null;
		}

		static function getUltimaLineaCarrito($idCarrito){
			$lineas = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT MAX(idLinea_Carrito) AS maxLinea FROM Linea_Carrito WHERE idCarrito = :idCarrito");

			$stmt->bindParam(':idCarrito',$idCarrito);

		    $stmt->execute();
		    $result = $stmt->fetch();

		    $maxLinea = $result['maxLinea'];

		    return $maxLinea;
			$con = null;
		}

		static function addLineaCarrito($linea,$uds){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Linea_Carrito VALUES (:idlc,:idc,:idcc,:nomp,:uds,:precio,:iva,:total)");

			$idCarrito = Modelo::getIdCarrito($linea['cliente']);

			$ultimaLinea = Modelo::getUltimaLineaCarrito($idCarrito);
			if($ultimaLinea != ""){
				$sigLinea = $ultimaLinea + 1;
			}else{
				$sigLinea = 1;
			}	

			$iva = 21;
			$totalLinea =  ($linea['precio'] + (($linea['precio'] * $iva)/100)) * $uds;

			$stmt->bindParam(':idlc',$sigLinea);
			$stmt->bindParam(':idc',$idCarrito);
			$stmt->bindParam(':idcc',$linea['idCopia_Cuadro']);
			$stmt->bindParam(':nomp',$linea['nombreProducto']);
			$stmt->bindParam(':uds',$uds);
			$stmt->bindParam(':precio',$linea['precio']);
			$stmt->bindParam(':iva',$iva);
			$stmt->bindParam(':total',$totalLinea);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows > 0){
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getIdCarrito($cliente){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idCarrito FROM Carrito WHERE email = :email");

			$stmt->bindParam(":email", $cliente);

			$stmt->execute();
		    $row = $stmt->fetch();

			$idCarrito = $row['idCarrito'];

		    return $idCarrito;

		    $con = null;
		}

		static function getTotalCarrito($idCarrito){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT SUM(totalLinea) AS totalCarrito FROM Linea_Carrito WHERE idCarrito = :idCarrito");

			$stmt->bindParam(':idCarrito',$idCarrito);

			$stmt->execute();
			$row = $stmt->fetch();

			$totalCarrito = $row['totalCarrito'];

			return $totalCarrito;

			$con = null;
		}

		static function borrarLineasCarrito($idLineas, $idCarrito){
			$con = Modelo::conectar();
			for ($i=0; $i < sizeof($idLineas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Linea_Carrito WHERE idLinea_Carrito = :id AND idCarrito = :idCarrito");

				$stmt->bindParam(':id', $idLineas[$i]);
				$stmt->bindParam(':idCarrito', $idCarrito);

				$stmt->execute();

				$affected_rows = $stmt->rowCount();
			}
			$con = null;
		}

		static function vaciarCarrito($idCarrito){
			$con = Modelo::conectar();
			$borraLineasCarrito = $con->prepare("DELETE FROM Linea_Carrito WHERE idCarrito = :idCarrito");

			$borraLineasCarrito->bindParam(':idCarrito', $idCarrito);

			$borraLineasCarrito->execute();

			$affected_rows = $borraLineasCarrito->rowCount();

			if($affected_rows > 0){
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function crearPedido($datos){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Pedido (email,fecha,precioTotal,estado) VALUES (:email,NOW(),:precioTotal,'En Espera')");

			$stmt->bindParam(':email', $datos['cliente']);
			$stmt->bindParam(':precioTotal', $datos['totalCarrito']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows > 0){
				Modelo::addLineasPedido($con->lastInsertId(),$datos['idCarrito']);
				Modelo::creaRecibo($con->lastInsertId());
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getUltimaLineaPedido($idPedido){
			$lineas = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT MAX(idLinea_Pedido) AS maxLinea FROM Linea_Pedido WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido',$idPedido);

		    $stmt->execute();
		    $result = $stmt->fetch();

		    $maxLinea = $result['maxLinea'];

		    return $maxLinea;
			$con = null;
		}

		static function addLineasPedido($idPedido,$idCarrito){			
			$con = Modelo::conectar();
			$lineasCarrito = Modelo::getLineasCarrito($idCarrito);

			foreach ($lineasCarrito as $linea) {
				$stmt = $con->prepare("INSERT INTO Linea_Pedido VALUES (:idl,:idp,:idc,:nomp,:uds,:precio,:iva,:total)");

				$ultimaLinea = Modelo::getUltimaLineaPedido($idPedido);
				if($ultimaLinea != ""){
					$sigLinea = $ultimaLinea + 1;
				}else{
					$sigLinea = 1;
				}

				$stmt->bindParam(':idl', $sigLinea);
				$stmt->bindParam(':idp', $idPedido);
				$stmt->bindParam(':idc', $linea['idCopia_Cuadro']);
				$stmt->bindParam(':nomp', $linea['nombreProducto']);
				$stmt->bindParam(':uds', $linea['unidades']);
				$stmt->bindParam(':precio', $linea['precio']);
				$stmt->bindParam(':iva', $linea['IVA']);
				$stmt->bindParam(':total', $linea['totalLinea']);

				$stmt->execute();
			}

			$con = null;
		}

		static function getPedidos($email){
			$pedidos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Pedido WHERE email = :email");

			$stmt->bindParam('email',$email);

			$stmt->execute();			
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$pedido = new Pedido($row['email'],$row['idPedido'],$row['fecha'],$row['precioTotal'],$row['estado']);
				$pedidos[] = $pedido;
		    }

		    return $pedidos;
			$con = null;
		}

		static function getPedidoPorId($idPedido){
			$con = Modelo::conectar();
			$stmtDPed = $con->prepare("SELECT * FROM Pedido WHERE idPedido = :idPedido");

			$stmtDPed->bindParam(':idPedido', $idPedido);
			$stmtDPed->execute();

			$row = $stmtDPed->fetch();

			$pedido = new Pedido($row['email'],$row['idPedido'],$row['fecha'],$row['precioTotal'],$row['estado']);

			return $pedido;

			$con = null;
			
		}

		static function getLineasPedido($idPedido){
			$lineas = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Pedido WHERE idPedido = :idPedido ORDER BY idLinea_Pedido ASC");

			$stmt->bindParam(':idPedido',$idPedido);

		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$linea = array(
					'idLinea_Pedido' => $row['idLinea_Pedido'],
					'idPedido' => $row['idPedido'],
					'idCopia_Cuadro' => $row['idCopia_Cuadro'],
					'nombreProducto' => $row['nombreProducto'],
					'unidades' => $row['unidades'],
					'precio' => $row['precio'],
					'IVA' => $row['IVA'],
					'totalLinea' => $row['totalLinea']
				);
				$lineas[] = $linea;
		    }
		    return $lineas;
			$con = null;
		}

		static function getTotalPedido($idPedido){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT SUM(totalLinea) AS totalPedido FROM Linea_Pedido WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido',$idPedido);

			$stmt->execute();
			$row = $stmt->fetch();

			$totalPedido = $row['totalPedido'];

			return $totalPedido;

			$con = null;
		}

		static function getEstadoDePedido($idPedido){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT estado FROM Pedido WHERE idPedido = :idPedido");

			$stmt->bindParam('idPedido', $idPedido);

			$stmt->execute();
			$row = $stmt->fetch();

			$estado = $row['estado'];

			return $estado;

			$con = null;
		}

		static function creaRecibo($idPedido){
			Modelo::insertaRecibo($idPedido);
			$idRecibo = Modelo::getIdRecibo($idPedido);
			Modelo::generaHtmlRecibo($idRecibo, $idPedido);
		}

		static function insertaRecibo($idPedido){
			$con = Modelo::conectar();
			$stmt = $con->prepare("INSERT INTO Recibo (idPedido) VALUES (:idp)");

			$stmt->bindParam(':idp',$idPedido);
			$stmt->execute();

			$con = null;
		}

		static function getIdRecibo($idPedido){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT idRecibo FROM Recibo WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido', $idPedido);
			$stmt->execute();

			$row = $stmt->fetch();

			return $row['idRecibo'];

			$con = null;
		}

		static function generaHtmlRecibo($idRecibo, $idPedido){
			$datosPedido = Modelo::getPedidoPorId($idPedido);
			$datosCliente = Modelo::getDatosCliente($_SESSION['cliente']);
			$lineasPedido = Modelo::getLineasPedido($idPedido);

			$recibo = new Recibo($idRecibo,$datosPedido,$datosCliente,$lineasPedido);
			$htmlRecibo = $recibo->genHtml();

			$con = Modelo::conectar();
			$stmt = $con->prepare("UPDATE Recibo SET ReciboHTML = :htmlRecibo WHERE idRecibo = :idRecibo");

			$stmt->bindParam(':idRecibo',$idRecibo);
			$stmt->bindParam(':htmlRecibo',$htmlRecibo);
			$stmt->execute();

			$con = null;
		}

		static function getHtmlRecibo($idPedido){
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT ReciboHTML FROM Recibo WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido',$idPedido);
			$stmt->execute();

			$row = $stmt->fetch();

			return $row['ReciboHTML'];

			$con = null;
		}
	}
?>