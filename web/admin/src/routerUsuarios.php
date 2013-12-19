<?php   
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$usuarios = $app['controllers_factory'];

	$usuarios->match('/clientes/cliente/{id}', function(Request $req, $id) use($app){
		return controlUsuarios::verFichaCliente($req, $app, $id);
	})->before($checkAdmin);

	$usuarios->match('/clientes/add', function(Request $req) use ($app){
		return controlUsuarios::addCliente($req, $app);
	})->before($checkAdmin);

	$usuarios->match('/clientes', function(Request $req) use ($app){
		return controlUsuarios::verClientes($req, $app);
	})->bind("ver_clientes")
	  ->before($checkAdmin);

	$usuarios->match('/admins/admin/{id}', function(Request $req, $id) use($app){
		return controlUsuarios::verFichaAdmin($req, $app, $id);
	})->before($checkAdmin);

	$usuarios->match('/admins/add', function(Request $req) use ($app){
		return controlUsuarios::addAdmin($req, $app);
	})->before($checkAdmin);

	$usuarios->match('/admins', function(Request $req) use ($app){
		return controlUsuarios::verAdmins($req, $app);
	})->bind("admins")
	  ->before($checkAdmin);

	return $usuarios;
?>