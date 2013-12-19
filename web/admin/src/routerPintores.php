<?php   
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$pintores = $app['controllers_factory'];

	$pintores->match('/pintor/{id}', function(Request $req, $id) use($app){
		return controlPintor::verFichaPintor($req, $app, $id);
	})->before($checkAdmin);

	$pintores->match('/add', function(Request $req) use ($app){
		return controlPintor::addPintor($req, $app);
	})->before($checkAdmin);

	$pintores->match('/', function(Request $req) use ($app){
		return controlPintor::verPintores($req, $app);
	})->bind("ver_pintores")
	  ->before($checkAdmin);

	return $pintores;
?>