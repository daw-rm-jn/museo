<?php 
	require_once __DIR__.'/../../vendor/autoload.php';
	require __DIR__.'/modelo/Modelo.php';
	require __DIR__.'/control/ListaControladores.php';

	/*---INYECCION DE DEPENDENCIAS--*/
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
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
	));//Twig, el sistema de templates para las vistas
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());//Generador de redirecciones
	$app->register(new FormServiceProvider());//Formularios
	$app->register(new Silex\Provider\TranslationServiceProvider(), array(
	    'locale' => 'es',
	    'fallback_locale' => 'en',
	));//Traductor para los mensajes de los formularios
	$app->register(new Silex\Provider\ValidatorServiceProvider());//Validador para los campos de los formularios

	$checkAdmin = function (Request $request) {
				    if(!isset($_SESSION['admin'])){
				    	return controlAdmin::noAuth();
				    }
				};//Función para comprobar si se ha iniciado sesión y restringir el acceso

	/*---ENRUTAMIENTO--*/

	/*--- PLANTAS DEL MUSEO ---*/
	$app->match('/plantas_museo/planta/{id}', function(Request $req, $id) use($app){
		return controlPlanta::verFichaPlanta($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/plantas_museo/add', function(Request $req) use ($app){
		return controlPlanta::addPlanta($req, $app);
	})->before($checkAdmin);

	$app->match('/plantas_museo', function(Request $req) use ($app){
		return controlPlanta::verPlantas($req, $app);
	})->before($checkAdmin);

	/*--- EXPOSICIONES ---*/
	$app->match('/exposiciones_museo/exposicion/{id}', function(Request $req, $id) use($app){
		return controlExposicion::verFichaExposicion($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/exposiciones_museo/add', function(Request $req) use ($app){
		return controlExposicion::addExposicion($req, $app);
	})->before($checkAdmin);

	$app->match('/exposiciones_museo', function(Request $req) use ($app){
		return controlExposicion::verExposiciones($req, $app);
	})->before($checkAdmin);

	/*--- ESTILOS ---*/
	$app->match('/estilos/estilo/{id}', function(Request $req, $id) use($app){
		return controlEstilo::verFichaEstilo($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/estilos/add', function(Request $req) use ($app){
		return controlEstilo::addEstilo($req, $app);
	})->before($checkAdmin);

	$app->match('/estilos', function(Request $req) use ($app){
		return controlEstilo::verEstilos($req, $app);
	})->before($checkAdmin);

	/*--- PINTORES ---*/
	$app->match('/pintores/pintor/{id}', function(Request $req, $id) use($app){
		return controlPintor::verFichaPintor($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/pintores/add', function(Request $req) use ($app){
		return controlPintor::addPintor($req, $app);
	})->before($checkAdmin);

	$app->match('/pintores', function(Request $req) use ($app){
		return controlPintor::verPintores($req, $app);
	})->before($checkAdmin);

	/*--- CUADROS ---*/
	$app->match('/cuadros/cuadro/{id}', function(Request $req, $id) use($app){
		return controlCuadro::verFichaCuadro($req, $app, $id);
	})->before($checkAdmin);

	$app->match('/cuadros/add', function(Request $req) use ($app){
		return controlCuadro::addCuadro($req, $app);
	})->before($checkAdmin);

	$app->match('/cuadros', function(Request $req) use ($app){
		return controlCuadro::verCuadros($req, $app);
	})->before($checkAdmin);

	/*--- MAIN ---*/
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