<?php 
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	$main = $app['controllers_factory'];

	$main->match('/logout', function() use($app){
		return controlAdmin::logOut($app);	
	})->bind('logout')
	  ->before($checkAdmin);

	$main->match('/login', function(Request $req) use($app){
		return controlAdmin::logIn($req, $app);
	})->bind('login');

	$main->match("/", function(Request $req) use ($app){
		return controlAdmin::main($req,$app);
	})->bind("inicio");

	return $main;
?>