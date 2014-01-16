<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;
	use Pagerfanta\Pagerfanta;
	use Pagerfanta\Adapter\ArrayAdapter;
	use Pagerfanta\View\DefaultView;

	class controlUsuarios{
		static function verClientes(Request $req, Application $app){
			$clientes = Modelo::getClientes();
			
			$adapter = new ArrayAdapter($clientes);
		    $pagerfanta = new Pagerfanta($adapter);
		    $pagerfanta->setMaxPerPage(25);
		    $page = $req->query->get('page', 1);
		    $pagerfanta->setCurrentPage($page);
		 
		    $routeGenerator = function($page) use ($app) {
		        return $app['url_generator']->generate('ver_clientes', array("page" => $page));
		    };
		 
		    $view = new DefaultView();
		    $htmlPagination = $view->render($pagerfanta, $routeGenerator, array(
		        'proximity' => 3,
		    ));

			$form = $app['form.factory']->createBuilder('form')
					->add('addRegistro', 'submit', array())
					->add('borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);
		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	if($form->get("borrar")->isClicked()){
						$emailClientes = $req->request->get('cb_borrar');
			        	Modelo::borrarClientes($emailClientes);
			        	return $app->redirect($app['url_generator']->generate('ver_clientes'));
		        	}else if($form->get("addRegistro")->isClicked()){
			        	return $app->redirect($app['url_generator']->generate('add_cliente'));
		        	}	
		        }
		    }

			return $app ['twig']->render('/usuarios/ver_clientes.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Administración de clientes',
				'pager' => $pagerfanta,
				'htmlPagination' => $htmlPagination,
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addCliente(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('clave', "text", array(
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
			        ->add('dir', "text", array())
			        ->add('pais', "text", array())
			        ->add('provincia', "text", array())
			        ->add('poblacion', "text", array())
			        ->add('cp', "text", array(
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
			        	)
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaCaducidad','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

					if(Modelo::addCliente($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Cliente añadido con éxito',
				    		'seccion' => 'usuarios/clientes'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Cliente',
				    		'seccion' => 'usuarios/clientes'
						));
					}
		        }
		    }

		    return $app['twig']->render('/usuarios/add_cliente.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir cliente',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaCliente(Request $req, Application $app, $id){
			$cliente = Modelo::getClientePorId($id);
			$datosBancarios = Modelo::getDatosBancarios($cliente);
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('clave', "text", array(
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
			        ->add('dir', "text", array())
			        ->add('pais', "text", array())
			        ->add('provincia', "text", array())
			        ->add('poblacion', "text", array())
			        ->add('cp', "text", array(
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
			        ->add('fechaAlta', 'text', array())
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	)
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaCaducidad','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);		       

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaCliente($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Cliente modificado con éxito',
				    		'seccion' => 'usuarios/clientes'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Cliente',
				    		'seccion' => 'usuarios/clientes'
						));
					}
		        }
		    }

		    return $app['twig']->render('/usuarios/ficha_cliente.twig', array(
		    	'form' => $form->createView(),
		    	'cliente' => $cliente,
		    	'datosBancarios' => $datosBancarios,
				'msgCabecera' => 'Ficha de cliente',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verAdmins(Request $req, Application $app){
			$admins = Modelo::getAdmins();
			
			$adapter = new ArrayAdapter($admins);
		    $pagerfanta = new Pagerfanta($adapter);
		    $pagerfanta->setMaxPerPage(25);
		    $page = $req->query->get('page', 1);
		    $pagerfanta->setCurrentPage($page);
		 
		    $routeGenerator = function($page) use ($app) {
		        return $app['url_generator']->generate('ver_admins', array("page" => $page));
		    };
		 
		    $view = new DefaultView();
		    $htmlPagination = $view->render($pagerfanta, $routeGenerator, array(
		        'proximity' => 3,
		    ));

			$form = $app['form.factory']->createBuilder('form')
					->add('addRegistro', 'submit', array())
					->add('borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);
		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	if($form->get("borrar")->isClicked()){
						$emailAdmins = $req->request->get('cb_borrar');
			        	Modelo::borrarAdmins($emailAdmins);
			        	return $app->redirect($app['url_generator']->generate('ver_admins'));
		        	}else if($form->get("addRegistro")->isClicked()){
			        	return $app->redirect($app['url_generator']->generate('add_admin'));
		        	}	
		        }
		    }

			return $app ['twig']->render('/usuarios/ver_admins.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Administración de administradores',
				'pager' => $pagerfanta,
				'htmlPagination' => $htmlPagination,
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addAdmin(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('clave', "text", array(
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
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

					if(Modelo::addAdmin($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Administrador añadido con éxito',
				    		'seccion' => 'usuarios/admins'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Administrador',
				    		'seccion' => 'usuarios/admins'
						));
					}
		        }
		    }

		    return $app['twig']->render('/usuarios/add_admin.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir cliente',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaAdmin(Request $req, Application $app, $id){
			$admin = Modelo::getAdminPorId($id);
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('clave', "text", array(
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
			        ->add('fechaAlta', 'text', array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);		       

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaAdmin($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Cliente modificado con éxito',
				    		'seccion' => 'usuarios/admins'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Cliente',
				    		'seccion' => 'usuarios/admins'
						));
					}
		        }
		    }

		    return $app['twig']->render('/usuarios/ficha_admin.twig', array(
		    	'form' => $form->createView(),
		    	'admin' => $admin,
				'msgCabecera' => 'Ficha de administrador',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}

?>