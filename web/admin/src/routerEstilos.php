<?php  
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$estilos = $app['controllers_factory'];

	$estilos->match('/estilo/{id}', function(Request $req, $id) use($app){
		return controlEstilo::verFichaEstilo($req, $app, $id);
	})->before($checkAdmin);

	$estilos->match('/add', function(Request $req) use ($app){
		return controlEstilo::addEstilo($req, $app);
	})->before($checkAdmin);

	$estilos->match('/', function(Request $req) use ($app){
		return controlEstilo::verEstilos($req, $app);
	})->bind("ver_estilos")
	  ->before($checkAdmin);

	return $estilos;
?>