<?php 
	require_once __DIR__.'/../../vendor/autoload.php';
	require __DIR__.'/modelo/Modelo.php';
	require __DIR__.'/controlador/listaControladores.php';

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
		return controladorPrincipal::pintores($app);
	})->bind('pintores');
        
        $app->match("/cuadros", function() use ($app){
		return controladorPrincipal::cuadros($app);
	})->bind("cuadros");
        
        $app->match("/tienda", function() use ($app){
		return controladorPrincipal::tienda($app);
	})->bind("tienda");
        
        $app->match("/carrito", function() use ($app){
		return controladorPrincipal::carrito($app);
	})->bind("carrito");


	$app->match("/", function() use ($app){
		return controladorPrincipal::main($app);
	})->bind("inicio");
        
        $app->match("/conectar", function(Request $req) use ($app){
		return controladorPrincipal::conectar($req, $app);
	})->bind("conectar");
        
        $app->match("/desconectar", function() use ($app){
		return controladorPrincipal::desconectar($app);
	})->bind("desconectar");
        
        
var_dump($_SESSION['user']);
	$app->run();//ARRANQUE DE LA APLICACION
 ?>