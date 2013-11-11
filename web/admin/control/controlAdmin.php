<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlAdmin{

		public function main(Application $app){
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

		public function logIn(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('Usuario', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )->add('Clave', "password", array(
			        	'constraints' => array(
			        			new Assert\NotBlank(),
			        		)
			        	)
					)->add('recordar', 'checkbox', array(
					    'label'     => 'Recordar sesión',
					    'required'  => false,
							)
					)->getForm();

		    if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
		           	$user = $data["Usuario"];
					$pass = $data["Clave"];
					if(Modelo::isAdmin($user, $pass)){
						$_SESSION['admin'] = $user;
						return $app->redirect($app['url_generator']->generate('inicio'));
					}
		        }
		    }

		    return $app['twig']->render('login.twig', array('form' => $form->createView()));
		}

		public function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array());
		}
	}
?>