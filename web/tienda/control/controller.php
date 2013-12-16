<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controller{

		/*static function noAuth(){
			$msg = "<h1>403 - Forbidden</h1>
					<br>
					<h2>No está autorizado a ver este contenido.</h2>";
			return new Response($msg, 403);
		}*/

		static function main(Application $app){
			$productos = Modelo::getProductos();
			return $app['twig']->render('inicio.twig', array(
				'productos' => $productos,
				'logged' => false
				)
			);
		}

		static function item(Application $app){
			return $app['twig']->render('item.twig', array());
		}

		/*static function logIn(Request $req, Application $app){
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
		}*/

		/*static function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array());
		}*/
	}
?>