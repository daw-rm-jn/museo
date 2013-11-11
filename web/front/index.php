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

	$app->run();
 ?>