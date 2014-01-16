<?php 
	require_once __DIR__.'/../../vendor/autoload.php'; 
	require_once __DIR__.'/control/controladorPrincipal.php';
	require_once __DIR__.'/modelo/modelo.php';


	/*---INYECCION DE DEPENDENCIAS--*/
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;
	
	session_start();

	
	$app = new Silex\Application();
	$app['debug'] = true;

	
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



	$app->match('/pintores', function() use ($app){
		return controladorPrincipal::pintores($app);
	})->bind('pintores');
        
        $app->match('/sup', function() use ($app){
		return controladorPrincipal::acerca($app);
	})->bind('sup');
        
        $app->match('/pintores/buscar', function(Request $req) use ($app){
		return controladorPrincipal::pintoresBuscar($req, $app);
	})->bind('pintoresBuscar');
        
        $app->match('/cuadros/buscar', function(Request $req) use ($app){
		return controladorPrincipal::cuadrosBuscar($req, $app);
	})->bind('cuadrosBuscar');
        
         $app->match("/cuadros", function() use ($app){
		return controladorPrincipal::cuadros($app);
	})->bind("cuadros");
       

	$app->match('/', function() use ($app){
		return controladorPrincipal::main($app);
	})->bind('inicio');

	$app->run();
 ?>