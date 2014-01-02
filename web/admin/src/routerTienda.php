<?php   
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$tienda = $app['controllers_factory'];

	$tienda->match('/productos/producto/{id}', function(Request $req, $id) use($app){
		return controlTienda::verFichaProducto($req, $app, $id);
	})->before($checkAdmin);

	$tienda->match('/productos/add', function(Request $req) use ($app){
		return controlTienda::addProducto($req, $app);
	})->bind("add_producto")
	  ->before($checkAdmin);

	$tienda->match('/productos', function(Request $req) use ($app){
		return controlTienda::verProductos($req, $app);
	})->bind("ver_productos")
	  ->before($checkAdmin);

	$tienda->match('/carritos/carrito/{id}/linea/{idLinea}', function(Request $req, $id, $idLinea) use($app){
		return controlTienda::verLinea_Carrito($req, $app, $id, $idLinea);
	})->before($checkAdmin);

	$tienda->match('/carritos/carrito/{id}', function(Request $req, $id) use($app){
		return controlTienda::verFichaCarrito($req, $app, $id);
	})->before($checkAdmin);

	$tienda->match('/carritos/add', function(Request $req) use ($app){
		return controlTienda::addCarrito($req, $app);
	})->bind("add_carrito")
	  ->before($checkAdmin);

	$tienda->match('/carritos', function(Request $req) use ($app){
		return controlTienda::verCarritos($req, $app);
	})->bind("ver_carritos")
	  ->before($checkAdmin);

	$tienda->match('/pedidos/pedido/{id}/linea/{idLinea}', function(Request $req, $id, $idLinea) use($app){
		return controlTienda::verLinea_Pedido($req, $app, $id, $idLinea);
	})->before($checkAdmin);

	$tienda->match('/pedidos/pedido/{id}', function(Request $req, $id) use($app){
		return controlTienda::verFichaPedido($req, $app, $id);
	})->before($checkAdmin);

	$tienda->match('/pedidos/add', function(Request $req) use ($app){
		return controlTienda::addPedido($req, $app);
	})->bind("add_pedido")
	  ->before($checkAdmin);

	$tienda->match('/pedidos', function(Request $req) use ($app){
		return controlTienda::verPedidos($req, $app);
	})->bind("ver_pedidos")
	  ->before($checkAdmin);

	return $tienda;
?>