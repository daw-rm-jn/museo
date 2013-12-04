<?php 
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$expos = $app['controllers_factory'];

	$expos->match('/exposicion/{id}', function(Request $req, $id) use($app){
		return controlExposicion::verFichaExposicion($req, $app, $id);
	})->before($checkAdmin);

	$expos->match('/add', function(Request $req) use ($app){
		return controlExposicion::addExposicion($req, $app);
	})->before($checkAdmin);

	$expos->match('/', function(Request $req) use ($app){
		return controlExposicion::verExposiciones($req, $app);
	})->before($checkAdmin);

	return $expos;

?>