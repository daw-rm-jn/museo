<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;

class controladorPrincipal {

    public static function main(Application $app) {

        if (isset($_SESSION['user'])) {
            return $app['twig']->render('index.twig', array('session' => $_SESSION['user']));
        } else {
            return $app['twig']->render('index.twig', array());
        }
    }
    
    public static function conectar(Request $req, Application $app) {
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
					if(Modelo::isUser($data)){
						$_SESSION['user'] = $data['Usuario'];
                                                
						return $app->redirect($app['url_generator']->generate('inicio'));
					}else{
						return $app['twig']->render('conectar.twig', array(
					    	'form' => $form->createView()
					    	)
					    );
					}
		        }
		    }
       
        
        if (isset($_SESSION['user'])) {
            return $app['twig']->render('conectar.twig', array('session' => $_SESSION['user'], 'form' => $form->createView()));
        } else {
            return $app['twig']->render('conectar.twig', array('form' => $form->createView()));
        }
    }

    public static function pintores(Application $app) {
        $pintores = Modelo::getPintores();
        return $app['twig']->render('pintores.twig', array(
                    'pintores' => $pintores));
    }

    public static function cuadros(Application $app) {
        $cuadros = Modelo::getCuadros();
        return $app['twig']->render('cuadros.twig', array(
                    'cuadros' => $cuadros));
    }
    
    public static function tienda(Application $app) {
        $cuadros = Modelo::getCuadros();
        return $app['twig']->render('tienda.twig', array(
                    'cuadros' => $cuadros));
    }
    public static function carrito(Application $app) {
      //  $cuadros = Modelo::getCarrito();
        return $app['twig']->render('carrito.twig', array(
                    'carrito' => $carrito));
    }
static function desconectar(Application $app){
			session_destroy();
			return $app['twig']->render('index.twig', array());
		}
}

?>
