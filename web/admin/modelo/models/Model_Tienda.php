<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Tienda{
		static function getCarritos(){
			$carritos = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Carrito ORDER BY idCarrito ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$carrito = new Carrito($row['idCarrito'],$row['email'],$row['fechaCreacion'],$row['fechaExpir']);
				$carritos[] = $carrito;
		    }
		    return $carritos;
			$con = null;
		}

		static function addCarrito($carrito){
			$con = Model_BD::conectar();
			$insertcarrito = $con->prepare("INSERT INTO Carrito (email,fechaCreacion,fechaExpir) VALUES (:email,NOW(),NOW()+INTERVAL 10 DAY)");

			$insertcarrito->bindParam(':email', $carrito['email']);

			$insertcarrito->execute();
			$affected_rows = $insertcarrito->rowCount();

			if($affected_rows >= 0){
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [CARRITO]',
						'descripcion' => 'Se ha insertado el registro Carrito con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
					return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function borrarCarritos($idCarritos){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idCarritos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Carrito WHERE idCarrito = :id");
				$borrarLineas = $con->prepare("DELETE FROM Linea_Carrito WHERE idCarrito = :id");
				
				$borrarLineas->bindParam(':id', $idCarritos[$i]);
				$stmt->bindParam(':id', $idCarritos[$i]);

				$borrarLineas->execute();
				$stmt->execute();

				$affected_rows_borrar = $borrarLineas->rowCount();
				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0 && $affected_rows_borrar >= 0){
					$act = array(
						'titulo' => 'BAJA [CARRITO]',
						'descripcion' => 'Se ha borrado el registro Carrito con id '. $idCarritos[$i] . '.',
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

		static function getCarritoPorId($idCarrito){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Carrito WHERE idCarrito = :idCarrito");

		    $stmt->bindParam(':idCarrito', $idCarrito);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$carrito = new Carrito($row['idCarrito'],$row['email'],$row['fechaCreacion'],$row['fechaExpir']);
			
		    return $carrito;
			$con = null;
		}

		static function modificaCarrito($carrito){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Carrito SET email = :email, fechaExpir = :fechaExpir WHERE idCarrito = :idCarrito");
						
			$stmt->bindParam(':email', $carrito['email']);
			$stmt->bindParam(':fechaExpir', $carrito['fechaExpir']);
			$stmt->bindParam(':idCarrito', $carrito['idCarrito']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$act = array(
						'titulo' => 'MODIFICACION [CARRITO]',
						'descripcion' => 'Se ha modificado el registro Carrito con id ' . $carrito['idCarrito'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getLineasCarrito($idCarrito){
			$lineas = array();
			$con = Model_BD::conectar();
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

		static function addLineaCarrito($carrito){
			$con = Model_BD::conectar();
			$insertlinea = $con->prepare("INSERT INTO Linea_Carrito VALUES (:idLinea,:idCarrito,:idCopia_Cuadro,:nombreProducto,:unidades,:precio,:IVA,:totalLinea)");

			$totalLinea =  ($carrito['precio'] + (($carrito['precio'] * $carrito['IVA'])/100)) * $carrito['unidades'];
			$lineasDelCarrito = Modelo::getLineasCarrito($carrito['idCarrito']);
			if(sizeof($lineasDelCarrito) > 0){
				$sigLinea = sizeof($lineasDelCarrito) + 1;
			}else{
				$sigLinea = 1;
			}			

			$insertlinea->bindParam(':idLinea',$sigLinea);
			$insertlinea->bindParam(':idCarrito',$carrito['idCarrito']);
			$insertlinea->bindParam(':idCopia_Cuadro',$carrito['idCopia_Cuadro']);
			$insertlinea->bindParam(':nombreProducto',$carrito['nombreProducto']);
			$insertlinea->bindParam(':unidades',$carrito['unidades']);
			$insertlinea->bindParam(':precio',$carrito['precio']);
			$insertlinea->bindParam(':IVA',$carrito['IVA']);
			$insertlinea->bindParam(':totalLinea',$totalLinea);

			$insertlinea->execute();
			$affected_rows = $insertlinea->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function borrarLineasCarrito($idLineas, $idCarrito){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idLineas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Linea_Carrito WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

				$stmt->bindParam(':idLinea', $idLineas[$i]);
				$stmt->bindParam(':idCarrito', $idCarrito);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getLineaCarritoPorId($idCarrito, $idLinea){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Carrito WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

		    $stmt->bindParam(':idLinea', $idLinea);
		    $stmt->bindParam(':idCarrito', $idCarrito);

		    $stmt->execute();
		    $row = $stmt->fetch();

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
		    return $linea;
			$con = null;
		}

		static function modificaLineaCarrito($linea){
			$con = Model_BD::conectar();
			$updatelinea = $con->prepare("UPDATE Linea_Carrito SET idCopia_Cuadro = :idCopia_Cuadro,nombreProducto = :nombreProducto,unidades = :unidades,precio = :precio,IVA = :IVA,totalLinea = :totalLinea WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

			$totalLinea =  ($linea['precio'] + (($linea['precio'] * $linea['IVA'])/100)) * $linea['unidades'];		

			$updatelinea->bindParam(':idLinea',$linea['idLinea_Carrito']);
			$updatelinea->bindParam(':idCarrito',$linea['idCarrito']);
			$updatelinea->bindParam(':idCopia_Cuadro',$linea['idCopia_Cuadro']);
			$updatelinea->bindParam(':nombreProducto',$linea['nombreProducto']);
			$updatelinea->bindParam(':unidades',$linea['unidades']);
			$updatelinea->bindParam(':precio',$linea['precio']);
			$updatelinea->bindParam(':IVA',$linea['IVA']);
			$updatelinea->bindParam(':totalLinea',$totalLinea);

			$updatelinea->execute();
			$affected_rows = $updatelinea->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function getPedidos(){
			$pedidos = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Pedido ORDER BY fecha ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$pedido = new Pedido($row['email'],$row['idPedido'],$row['fecha'],$row['precioTotal'],$row['estado']);
				$pedidos[] = $pedido;
		    }
		    return $pedidos;
			$con = null;
		}

		static function getPrecioTotalPedido($idPedido){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT SUM(totalLinea) AS precioTotalPedido FROM Linea_Pedido WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido', $idPedido);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$precioTotal = $row['precioTotalPedido'];
			
		    return $precioTotal;
			$con = null;
		}

		static function setPrecioTotalPedido($idPedido){
			$precioTotal = Model_Tienda::getPrecioTotalPedido($idPedido);
			if($precioTotal == null){
				$precioTotal = 0;
			}
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Pedido SET precioTotal = :precioTotal WHERE idPedido = :idPedido");

			$stmt->bindParam(':idPedido', $idPedido);
			$stmt->bindParam(':precioTotal', $precioTotal);

		    $stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
		}

		static function borrarPedidos($idPedidos){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idPedidos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Pedido WHERE idPedido = :id");
				$borrarLineas = $con->prepare("DELETE FROM Linea_Pedido WHERE idPedido = :id");
				
				$borrarLineas->bindParam(':id', $idPedidos[$i]);
				$stmt->bindParam(':id', $idPedidos[$i]);

				$borrarLineas->execute();
				$stmt->execute();

				$affected_rows_borrar = $borrarLineas->rowCount();
				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0 && $affected_rows_borrar >= 0){
					$act = array(
						'titulo' => 'BAJA [PEDIDO]',
						'descripcion' => 'Se ha borrado el registro Pedido con id '. $idPedidos[$i] . '.',
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

		static function addPedido($pedido){
			$con = Model_BD::conectar();
			$insertpedido = $con->prepare("INSERT INTO Pedido (email,fecha,precioTotal,estado) VALUES (:email,:fecha,0, 'En Espera')");

			$insertpedido->bindParam(':email', $pedido['email']);
			$insertpedido->bindParam(':fecha', $pedido['fecha']);

			$insertpedido->execute();
			$affected_rows = $insertpedido->rowCount();

			if($affected_rows >= 0){
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [PEDIDO]',
						'descripcion' => 'Se ha insertado el registro Pedido con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function getPedidoPorId($idPedido){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Pedido WHERE idPedido = :idPedido");

		    $stmt->bindParam(':idPedido', $idPedido);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$pedido = new Pedido($row['email'],$row['idPedido'],$row['fecha'],$row['precioTotal'],$row['estado']);
			
		    return $pedido;
			$con = null;
		}

		static function modificaPedido($pedido, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Pedido SET email = :email,fecha = :fecha,precioTotal = :precioTotal,estado = :estado WHERE idPedido = :idPedido");
						
			$stmt->bindParam(':email', $pedido['email']);
			$stmt->bindParam(':idPedido', $pedido['idPedido']);
			$stmt->bindParam(':fecha', $pedido['fecha']);
			$stmt->bindParam(':precioTotal', $pedido['precioTotal']);
			$stmt->bindParam(':estado', $descriptor['estado']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$act = array(
						'titulo' => 'MODIFICACION [PEDIDO]',
						'descripcion' => 'Se ha modificado el registro Pedido con id ' . $pedido['idPedido'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getLineasPedido($idPedido){
			$lineas = array();
			$con = Model_BD::conectar();
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

		static function addLineaPedido($pedido){
			$con = Model_BD::conectar();
			$insertlinea = $con->prepare("INSERT INTO Linea_Pedido VALUES (:idLinea,:idPedido,:idCopia_Cuadro,:nombreProducto,:unidades,:precio,:IVA,:totalLinea)");

			$totalLinea =  ($pedido['precio'] + (($pedido['precio'] * $pedido['IVA'])/100)) * $pedido['unidades'];
			$lineasDelPedido = Modelo::getLineasPedido($pedido['idPedido']);
			if(sizeof($lineasDelPedido) > 0){
				$sigLinea = sizeof($lineasDelPedido) + 1;
			}else{
				$sigLinea = 1;
			}			

			$insertlinea->bindParam(':idLinea',$sigLinea);
			$insertlinea->bindParam(':idPedido',$pedido['idPedido']);
			$insertlinea->bindParam(':idCopia_Cuadro',$pedido['idCopia_Cuadro']);
			$insertlinea->bindParam(':nombreProducto',$pedido['nombreProducto']);
			$insertlinea->bindParam(':unidades',$pedido['unidades']);
			$insertlinea->bindParam(':precio',$pedido['precio']);
			$insertlinea->bindParam(':IVA',$pedido['IVA']);
			$insertlinea->bindParam(':totalLinea',$totalLinea);

			$insertlinea->execute();
			$affected_rows = $insertlinea->rowCount();

			if($affected_rows >= 0){
				Model_Tienda::setPrecioTotalPedido($pedido['idPedido']);
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function borrarLineasPedido($idLineas, $idPedido){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idLineas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Linea_Pedido WHERE idLinea_Pedido = :idLinea AND idPedido = :idPedido");

				$stmt->bindParam(':idLinea', $idLineas[$i]);
				$stmt->bindParam(':idPedido', $idPedido);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					Model_Tienda::setPrecioTotalPedido($idPedido);
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getLineaPedidoPorId($idPedido, $idLinea){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Pedido WHERE idLinea_Pedido = :idLinea AND idPedido = :idPedido");

		    $stmt->bindParam(':idLinea', $idLinea);
		    $stmt->bindParam(':idPedido', $idPedido);

		    $stmt->execute();
		    $row = $stmt->fetch();

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
		    return $linea;
			$con = null;
		}

		static function modificaLineaPedido($linea){
			$con = Model_BD::conectar();
			$updatelinea = $con->prepare("UPDATE Linea_Pedido SET idCopia_Cuadro = :idCopia_Cuadro,nombreProducto = :nombreProducto,unidades = :unidades,precio = :precio,IVA = :IVA,totalLinea = :totalLinea WHERE idLinea_Pedido = :idLinea AND idPedido = :idPedido");

			$totalLinea =  ($linea['precio'] + (($linea['precio'] * $linea['IVA'])/100)) * $linea['unidades'];		

			$updatelinea->bindParam(':idLinea',$linea['idLinea_Pedido']);
			$updatelinea->bindParam(':idPedido',$linea['idPedido']);
			$updatelinea->bindParam(':idCopia_Cuadro',$linea['idCopia_Cuadro']);
			$updatelinea->bindParam(':nombreProducto',$linea['nombreProducto']);
			$updatelinea->bindParam(':unidades',$linea['unidades']);
			$updatelinea->bindParam(':precio',$linea['precio']);
			$updatelinea->bindParam(':IVA',$linea['IVA']);
			$updatelinea->bindParam(':totalLinea',$totalLinea);

			$updatelinea->execute();
			$affected_rows = $updatelinea->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function getProductos(){
			$productos = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro ORDER BY idCopia_cuadro ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }
		    return $productos;
			$con = null;
		}

		static function addProducto($producto, $descriptor){			
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Copia_Cuadro (nombreProducto,autor,estilo,orientacion,anioCuadro,fechaAlta,descripcion,precio,fotoCuadro) VALUES (:nomp,:idp,:ide,:orc,:anioc,NOW(),:descp,:preciop,:imgp)");

			$stmt->bindParam(':nomp', $producto['nombreProducto']);
			$stmt->bindParam(':orc', $producto['orientacion']);
			$stmt->bindParam(':anioc', $producto['anioCuadro']);
			$stmt->bindParam(':idp', $descriptor['pintor']);
			$stmt->bindParam(':ide', $descriptor['estilo']);
			$stmt->bindParam(':descp', $descriptor['descripcion']);
			$stmt->bindParam(':preciop', $producto['precio']);
			$stmt->bindParam(':imgp', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [PRODUCTO]',
						'descripcion' => 'Se ha insertado el registro Producto con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function borrarProductos($idProductos){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idProductos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Copia_Cuadro WHERE idCopia_Cuadro = :idLinea");

				$stmt->bindParam(':idLinea', $idProductos[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$act = array(
						'titulo' => 'BAJA [PRODUCTO]',
						'descripcion' => 'Se ha borrado el registro Producto con id '. $idProductos[$i] . '.',
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

		static function getProductoPorId($idProducto){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro WHERE idCopia_Cuadro = :idCopia_Cuadro");

		    $stmt->bindParam(':idCopia_Cuadro', $idProducto);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
						
		    return $producto;
			$con = null;
		}

		static function modificaProducto($producto, $descriptor){			
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Copia_Cuadro SET nombreProducto = :nomp,autor = :idp,estilo = :ide,orientacion = :orc, anioCuadro = anioc,descripcion = :descp,precio = :preciop,fotoCuadro = :imgp WHERE idCopia_Cuadro = :idcc");

			$stmt->bindParam(':idcc', $producto['idCopia_Cuadro']);
			$stmt->bindParam(':nomp', $producto['nombreProducto']);
			$stmt->bindParam(':orc', $producto['orientacion']);
			$stmt->bindParam(':anioc', $producto['anioCuadro']);
			$stmt->bindParam(':idp', $descriptor['pintor']);
			$stmt->bindParam(':ide', $descriptor['estilo']);
			$stmt->bindParam(':descp', $descriptor['descripcion']);
			$stmt->bindParam(':preciop', $producto['precio']);
			$stmt->bindParam(':imgp', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$act = array(
						'titulo' => 'MODIFICACION [PRODUCTO]',
						'descripcion' => 'Se ha modificado el registro Producto con id ' . $producto['idCopia_Cuadro'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}
	}
?>