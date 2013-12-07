<?php 
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	$museo = $app['controllers_factory'];

	$museo->match('/exposiciones_museo/exposicion/{id}', function(Request $req, $id) use($app){
		return controlMuseo::verFichaExposicion($req, $app, $id);
	})->before($checkAdmin);

	$museo->match('/exposiciones_museo/add', function(Request $req) use ($app){
		return controlMuseo::addExposicion($req, $app);
	})->before($checkAdmin);

	$museo->match('/exposiciones_museo', function(Request $req) use ($app){
		return controlMuseo::verExposiciones($req, $app);
	})->before($checkAdmin);

	$museo->match('/plantas_museo/planta/{id}', function(Request $req, $id) use($app){
		return controlMuseo::verFichaPlanta($req, $app, $id);
	})->before($checkAdmin);

	$museo->match('/plantas_museo/add', function(Request $req) use ($app){
		return controlMuseo::addPlanta($req, $app);
	})->before($checkAdmin);

	$museo->match('/plantas_museo', function(Request $req) use ($app){
		return controlMuseo::verPlantas($req, $app);
	})->before($checkAdmin);

	$museo->match('/salas_museo/sala/{id}', function(Request $req, $id) use($app){
		return controlMuseo::verFichaSala($req, $app, $id);
	})->before($checkAdmin);

	$museo->match('/salas_museo/add', function(Request $req) use ($app){
		return controlMuseo::addSala($req, $app);
	})->before($checkAdmin);

	$museo->match('/salas_museo', function(Request $req) use ($app){
		return controlMuseo::verSalas($req, $app);
	})->before($checkAdmin);

	return $museo;
?>