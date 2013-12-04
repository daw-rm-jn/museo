<?php
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$plantas = $app['controllers_factory'];

	$plantas->match('/planta/{id}', function(Request $req, $id) use($app){
		return controlPlanta::verFichaPlanta($req, $app, $id);
	})->before($checkAdmin);

	$plantas->match('/add', function(Request $req) use ($app){
		return controlPlanta::addPlanta($req, $app);
	})->before($checkAdmin);

	$plantas->match('/', function(Request $req) use ($app){
		return controlPlanta::verPlantas($req, $app);
	})->before($checkAdmin);
	 
	return $plantas;
?>