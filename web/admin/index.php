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

	/*--- TIENDA ---*/
	//$app->mount('/tienda', include __DIR__. '/src/routerTienda.php');

	/*--- USUARIOS ---*/
	$app->mount('/usuarios', include __DIR__. '/src/routerUsuarios.php');

	/*--- MUSEO ---*/
	$app->mount('/museo', include __DIR__ . '/src/routerMuseo.php');
	
	/*--- ESTILOS ---*/
	$app->mount('/estilos', include __DIR__ . '/src/routerEstilos.php');
	
	/*--- PINTORES ---*/
	$app->mount('/pintores', include __DIR__ . '/src/routerPintores.php');
	
	/*--- CUADROS ---*/
	$app->mount('/cuadros', include __DIR__ . '/src/routerCuadros.php');	

	/*--- MAIN ---*/
	$app->mount('/', include __DIR__ . '/src/routerMain.php');	
	

	$app->run();//ARRANQUE DE LA APLICACION
 ?>