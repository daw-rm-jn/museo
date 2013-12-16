<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlAdmin{

		static function noAuth(){
			$msg = "<h1>403 - Forbidden</h1>
					<br>
					<h2>No está autorizado a ver este contenido.</h2>";
			return new Response($msg, 403);
		}

		static function main(Application $app){
			$updates = Modelo::getUpdates();
			if(isset($_SESSION['admin'])){
				return $app['twig']->render('inicio.twig', array(
					'updates' => $updates,
		    		'sessionId' => $_SESSION['admin'],
		    		'msgCabecera' => 'Bienvenido al panel de aministración'
				));
			}else{
				return $app->redirect($app['url_generator']->generate('login'));
			}
		}

		static function logIn(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('usuario', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
			        ->add('clave', "password", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 50
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("clavecifrada", "hidden", array())
					->getForm();

		    if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::isAdmin($data)){
						$_SESSION['admin'] = $data['usuario'];
						return $app->redirect($app['url_generator']->generate('inicio'));
					}else{
						return $app['twig']->render('login.twig', array(
					    	'form' => $form->createView()
					    	)
					    );
					}
		        }
		    }

		    return $app['twig']->render('login.twig', array(
		    	'form' => $form->createView()
		    	)
		    );
		}

		static function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array());
		}
	}
?>