<?php
	namespace control;

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;

	class controlAdmin{

		public function main(Application $app){
			if(isset($_SESSION['admin'])){
				return $app['twig']->render('inicio.twig', array());
			}else{
				return $app['twig']->render('login.twig', array());
			}
		}

		public function logIn(Request $req, Application $app){
			$user = $req->request->get("logUser");
			$pass = $req->request->get("logPass");
			if('modelo\Modelo::isAdmin'){
				$_SESSION['admin'] = $user;
				return $app->redirect($app['url_generator']->generate('inicio'));
			}
		}

		public function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array());
		}
	}
?>