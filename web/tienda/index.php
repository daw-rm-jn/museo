<?php 
	require_once __DIR__.'/../../vendor/autoload.php'; //Clase de carga del framework
	require_once __DIR__.'/control/Controller.php';
	require_once __DIR__.'/modelo/Modelo.php';
	require __DIR__.'/html2pdf/html2pdf.class.php';


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

	$checkCliente = function (Request $request) use ($app){
				    if(!isset($_SESSION['cliente'])){
				    	return Controller::noAuth($app);
				    }
				};//Función para comprobar si se ha iniciado sesión y restringir el acceso

	/*---ENRUTAMIENTO--*/

	$app->match('/buscar', function(Request $req) use ($app){
		return Controller::buscar($req, $app);
	});

	$app->match('/pedidos/pedido/{id}', function(Request $req, $id) use ($app){
		return Controller::verDetallesPedido($req, $app, $id);
	})->before($checkCliente);

	$app->match('/ver_pedidos', function() use ($app){
		return Controller::verPedidos($app);
	})->bind("ver_pedidos")
	  ->before($checkCliente);

	$app->match('/ver_carrito', function(Request $req) use ($app){
		return Controller::verCarrito($req, $app);
	})->bind("ver_carrito")
	  ->before($checkCliente);

	$app->match('/mi_cuenta', function(Request $req) use ($app){
		return Controller::verDatosCuenta($req, $app);
	})->before($checkCliente);

	$app->match('/expos/{nombre}', function($nombre) use ($app){
		return Controller::detalleExpo($app,$nombre);
	});

	$app->match('/estilos/{nombre}', function($nombre) use ($app){
		return Controller::detalleEstilo($app,$nombre);
	});

	$app->match('/pintores/{nombre}', function($nombre) use ($app){
		return Controller::detallePintor($app,$nombre);
	});

	$app->match('/ver_pintores', function() use ($app){
		return Controller::verPintores($app);
	});

	$app->match('/ver_expos', function() use ($app){
		return Controller::verExpos($app);
	});

	$app->match('/ver_estilos', function() use ($app){
		return Controller::verEstilos($app);
	});

	$app->match('/ver_cuadros', function() use ($app){
		return Controller::verCuadros($app);
	});

	$app->match('/sign', function(Request $req) use ($app){
		return Controller::signIn($req, $app);
	});

	$app->match('/logout', function() use ($app){
		return Controller::logout($app);
	});

	$app->match('/login', function(Request $req) use ($app){
		return Controller::logIn($req,$app);
	})->bind('login');

	$app->match('/item/{id}', function(Request $req, $id) use ($app){
		return Controller::item($req,$app, $id);
	});

	$app->match('/', function() use ($app){
		return Controller::main($app);
	})->bind('inicio');

	$app->run();//ARRANQUE DE LA APLICACION
 ?>