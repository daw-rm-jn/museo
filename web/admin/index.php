<?php 
	require_once __DIR__.'/../../vendor/autoload.php';
	require __DIR__.'/modelo/Modelo.php';
	require __DIR__.'/control/ListaControladores.php';

	/*---INYECCION DE DEPENDENCIAS--*/
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
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

	$checkAdmin = function (Request $request) {
				    if(!isset($_SESSION['admin'])){
				    	return controlAdmin::noAuth();
				    }
				};

	/*---ENRUTAMIENTO--*/
	$app->match('/estilos/estilo/{id}', function(Request $req, $id) use($app){
		return controlEstilo::verFichaEstilo($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/estilos/add', function(Request $req) use ($app){
		return controlEstilo::addEstilo($req, $app);
	})->before($checkAdmin);

	$app->match('/estilos', function(Request $req) use ($app){
		return controlEstilo::verEstilos($req, $app);
	})->bind('ver_estilos')
	  ->before($checkAdmin);

	$app->match('/pintores/add', function(Request $req) use ($app){
		return controlPintor::addPintor($req, $app);
	})->before($checkAdmin);

	$app->match('/pintores/pintor/{id}', function(Request $req, $id) use($app){
		return controlPintor::verFichaPintor($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/pintores', function(Request $req) use ($app){
		return controlPintor::verPintores($req, $app);
	})->bind('ver_pintores')
	  ->before($checkAdmin);

	$app->match('/cuadros/add', function(Request $req) use ($app){
		return controlCuadro::addCuadro($req, $app);
	})->before($checkAdmin);

	$app->match('/cuadros', function(Request $req) use ($app){
		return controlCuadro::verCuadros($req, $app);
	})->bind('ver_cuadros')
	  ->before($checkAdmin);

	$app->match('/logout', function() use($app){
		return controlAdmin::logOut($app);	
	})->bind('logout')
	  ->before($checkAdmin);

	$app->match('/login', function(Request $req) use($app){
		return controlAdmin::logIn($req, $app);
	})->bind('login');

	$app->match("/", function() use ($app){
		return controlAdmin::main($app);
	})->bind("inicio");

	$app->run();//ARRANQUE DE LA APLICACION
 ?>