<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class Controller{

		static function noAuth($app){
			return $app->redirect($app['url_generator']->generate('login'));
		}

		static function checkLog(){
			if(isset($_SESSION['cliente'])){
				return true;
			}else{
				return false;
			}
		}

		static function main(Application $app){
			$productos = Modelo::getUltimosProductos();
			$logged = Controller::checkLog();
				return $app['twig']->render('inicio.twig', array(
					'productos' => $productos,
					'logged' => $logged
					)
				);
			
		}

		static function item(Application $app){
			$logged = Controller::checkLog();
			return $app['twig']->render('item.twig', array(
				'logged' => $logged
				)
			);
		}

		static function logIn(Request $req, Application $app){
			$logged = Controller::checkLog();
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
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("clavecifrada", "hidden", array())
			        ->add("acceder", "submit", array())
					->getForm();

		    if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::isCliente($data)){
						$_SESSION['cliente'] = $data['usuario'];
						return $app->redirect($app['url_generator']->generate('inicio'));
					}else{
						return $app['twig']->render('login.twig', array(
					    	'form' => $form->createView(),
					    	'logged' => $logged,
					    	'msgerr' => 'Nombre de Usuario a contraseña no válidos.'
					    	)
					    );
					}
		        }
		    }

		    return $app['twig']->render('login.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => false,
				'msgerr' => ''
		    	)
		    );
		}

		static function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array(
				'logged' => false,
				'user' => 'usuario anónimo'
				)
			);
		}

		static function signIn(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
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
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("clavecifrada", "hidden", array())
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(X(-|\.)?0?\d{7}(-|\.)?[A-Z]|[A-Z](-|\.)?\d{7}(-|\.)? [0-9A-Z]|\d{8}(-|\.)?[A-Z])$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('direccion', "text", array())
			        ->add('codigoPostal', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('telf', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^[9|8|6|7][0-9]{8}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('registrar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$fechaCad = $req->request->get('selfechCadAnio') . '-' . $req->request->get('selfechCadMes') . '-01';

					if(Modelo::registroCliente($data, $fechaCad)){
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Registro completo',
							'msg' => 'El registro de su cuenta se ha completado satisfactoriamente, puede acceder a su cuenta desde el menú superior',
							'logged' => false
						));
					}else{
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Error en el registro',
							'msg' => 'Ha ocurrido un error durante el registro, inténtelo de nuevo.',
							'logged' => false
						));
					}
		        }
		    }

		    return $app['twig']->render('sign.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => false,
		    	'curYear' => date("Y")
		    	)
		    );
		}

		static function verDatosCuenta(Request $req, Application $app){
			$datosCuenta = Modelo::getDatosCliente($_SESSION['cliente']);
			$datosBanc = Modelo::getDatosBanc($_SESSION['cliente']);
			$fechCad = explode("-", $datosBanc['fechaCaducidad']);
			$form = $app['form.factory']->createBuilder('form')
					->add('email','hidden',array())
			        ->add('claveActual', "password", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("claveactualcifrada", "hidden", array())
			        ->add('claveNueva', "password", array(
			        	'constraints' => array( 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    ),
			        	'required' => false
			        	)
			        )
			        ->add("clavenuevacifrada", "hidden", array())
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(X(-|\.)?0?\d{7}(-|\.)?[A-Z]|[A-Z](-|\.)?\d{7}(-|\.)? [0-9A-Z]|\d{8}(-|\.)?[A-Z])$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('direccion', "text", array())
			        ->add('codigoPostal', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('telf', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^[9|8|6|7][0-9]{8}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('guardar', 'submit', array())
			        ->add('borrarCuenta', 'submit', array())
			        ->getForm();

		  if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$fechaCad = $req->request->get('selfechCadAnio') . '-' . $req->request->get('selfechCadMes') . '-01';

		        	if($form->get("guardar")->isClicked()){
		        		if(Modelo::modificaCuenta($data, $fechaCad)){
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Datos modificados',
								'msg' => 'Sus datos se han modificado correctamente',
								'logged' => true
							));
						}else{
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Error',
								'msg' => 'Ha ocurrido un error durante la modificación de datos, inténtelo de nuevo.',
								'logged' => true
							));
						}
		        	}else if($form->get("borrarCuenta")->isClicked()){
		        		session_destroy();
		        		if(Modelo::borrarCuenta($datosCuenta->getEmail())){
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Usuario borrado',
								'msg' => 'Sus cuenta se ha borrado correctamente',
								'logged' => false
							));
						}else{
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Error',
								'msg' => 'Ha ocurrido un error durante la baja de su cuenta, inténtelo de nuevo.',
								'logged' => true
							));
						}
		        	}
		        }
		    }

		    return $app['twig']->render('mi_cuenta.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => true,
		    	'curYear' => date("Y"),
		    	'cliente' => $datosCuenta,
		    	'datosBanc' => $datosBanc,
		    	'fechCad' => $fechCad
		    	)
		    );
		}
	}
?>