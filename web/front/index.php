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

	$app->get('/logout', 'control\controlAdmin::logOut');

	$app->get('/login', 'control\controlAdmin::logIn')->method("POST");

	$app->get("/", "control\controlAdmin::main")->bind("inicio");
        
        $app->get("/pintores", "control\controlAdmin::main")->bind("pintores");
        
        $app->get("/cuadros", "control\controlAdmin::main")->bind("cuadros");

        $app->get("/carrito", "control\controlAdmin::main")->bind("carrito");

        $app->get("/miusuario", "control\controlAdmin::main")->bind("usuario");


	$app->run();
 ?>