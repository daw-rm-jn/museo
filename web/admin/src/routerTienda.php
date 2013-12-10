<?php   
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$tienda = $app['controllers_factory'];

	$tienda->match('/carritos/carrito/{id}/linea/{idLinea}', function(Request $req, $id, $idLinea) use($app){
		return controlTienda::verLinea_Carrito($req, $app, $id, $idLinea);
	})->before($checkAdmin);

	$tienda->match('/carritos/carrito/{id}', function(Request $req, $id) use($app){
		return controlTienda::verFichaCarrito($req, $app, $id);
	})->before($checkAdmin);

	$tienda->match('/carritos/add', function(Request $req) use ($app){
		return controlTienda::addCarrito($req, $app);
	})->before($checkAdmin);

	$tienda->match('/carritos', function(Request $req) use ($app){
		return controlTienda::verCarritos($req, $app);
	})->before($checkAdmin);

	$tienda->match('/pedidos/pedido/{id}/linea/{idLinea}', function(Request $req, $id, $idLinea) use($app){
		return controlTienda::verLinea_Pedidoo($req, $app, $id, $idLinea);
	})->before($checkAdmin);

	$tienda->match('/pedidos/pedido/{id}', function(Request $req, $id) use($app){
		return controlTienda::verFichaPedido($req, $app, $id);
	})->before($checkAdmin);

	$tienda->match('/pedidos/add', function(Request $req) use ($app){
		return controlTienda::addPedido($req, $app);
	})->before($checkAdmin);

	$tienda->match('/pedidos', function(Request $req) use ($app){
		return controlTienda::verPedidos($req, $app);
	})->before($checkAdmin);

	return $tienda;
?>