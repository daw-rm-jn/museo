<?php 
	require_once __DIR__.'/../../vendor/autoload.php';
	require __DIR__.'/modelo/Modelo.php';
	require __DIR__.'/control/ListaControladores.php';

	/*---INYECCION DE DEPENDENCIAS--*/
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\Validator\Constraints as Assert;
	
	session_start();

	/*---INICIALIZACION DEL FRAMEWORK--*/
	$app = new Silex\Application();
	$app['debug'] = true;

	/*---REGISTRO DE PROVEEDORES DE SERVICIOS--*/
	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/vistas'
	));
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
	$app->register(new FormServiceProvider());
	$app->register(new Silex\Provider\TranslationServiceProvider(), array(
	    'locale' => 'es',
	    'fallback_locale' => 'en',
	));
	$app->register(new Silex\Provider\ValidatorServiceProvider());


	/*---ENRUTAMIENTO--*/
	$app->match('/pintores/pintor/{id}', function(Request $req, $id) use($app){
		return controlPintor::verFichaPintor($req, $app, $id);
	});

	$app->match('/pintores', function() use ($app){
		return controlPintor::verPintores($app);
	})->bind('ver_pintores');

	$app->match('/cuadros', function() use ($app){
		return controlCuadros::verCuadros($app);
	})->bind('ver_cuadros');

	$app->match('/logout', function() use($app){
		return controlAdmin::logOut($app);	
	})->bind('logout');

	$app->match('/login', function(Request $req) use($app){
		return controlAdmin::logIn($req, $app);
	})->bind('login');

	$app->match("/", function() use ($app){
		return controlAdmin::main($app);
	})->bind("inicio");

	$app->run();//ARRANQUE DE LA APLICACION
 ?>