<?php 
	require_once __DIR__.'/../../vendor/autoload.php';
	require_once __DIR__.'/control/controller.php';
	require_once __DIR__.'/modelo/Modelo.php';


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

	$app->match('/item', function() use ($app){
		return controller::item($app);
	});

	$app->match('/', function() use ($app){
		return controller::main($app);
	});

	$app->run();//ARRANQUE DE LA APLICACION
 ?>