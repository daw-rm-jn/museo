<?php   
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$cuadros = $app['controllers_factory'];

	$cuadros->match('/cuadro/{id}', function(Request $req, $id) use($app){
		return controlCuadro::verFichaCuadro($req, $app, $id);
	})->before($checkAdmin);

	$cuadros->match('/add', function(Request $req) use ($app){
		return controlCuadro::addCuadro($req, $app);
	})->before($checkAdmin);

	$cuadros->match('/', function(Request $req) use ($app){
		return controlCuadro::verCuadros($req, $app);
	})->before($checkAdmin);

	return $cuadros;
?>