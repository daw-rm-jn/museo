<?php 
	require_once __DIR__.'/../../vendor/autoload.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	
	session_start();

	$app = new Silex\Application();
	$app['debug'] = true;

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/vistas'
	));
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


	$app->get("/", "controlalor\controladorPrincipal::main")->bind("inicio");
        
        $app->get("/pintores", "controlalor\controladorPrincipal::main")->bind("pintores");
        
        $app->get("/cuadros", "controlalor\controladorPrincipal::main")->bind("cuadros");

        $app->get("/carrito", "controlalor\controladorPrincipal::main")->bind("carrito");

        $app->get("/miusuario", "controlalor\controladorPrincipal::main")->bind("usuario");


	$app->run();
 ?>