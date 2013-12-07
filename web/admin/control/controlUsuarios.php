<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlUsuarios{
		static function verClientes(Request $req, Application $app){
			$clientes = Modelo::getClientes();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$emailClientes = $req->request->get('cb_borrar');
		        	if(Modelo::borrarClientes($emailClientes)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'usuarios/clientes',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'usuarios/clientes',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/usuarios/ver_clientes.twig', array(
		    	'form' => $form_borrar->createView(),
				'clientes' => $clientes,
				'msgCabecera' => 'Administración de clientes',
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
						            'max' => 50
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/[0-9]{7,8}[A-Z]/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('dir', "text", array())
			        ->add('cp', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(5[0-2]|[0-4][0-9])[0-9]{3}$/'
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
						            'max' => 50
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/[0-9]{7,8}[A-Z]/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('dir', "text", array())
			        ->add('cp', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(5[0-2]|[0-4][0-9])[0-9]{3}$/'
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
				'msgCabecera' => 'Ficha de cliente',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verAdmins(Request $req, Application $app){
			$admins = Modelo::getAdmins();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$emailAdmins = $req->request->get('cb_borrar');
		        	if(Modelo::borrarAdmins($emailAdmins)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'usuarios/admins',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'usuarios/admins',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/usuarios/ver_admins.twig', array(
		    	'form' => $form_borrar->createView(),
				'admins' => $admins,
				'msgCabecera' => 'Administración de administradores',
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
						            'max' => 50
						    	    )
						    	)
						    )
			        	)
			        )
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
						            'max' => 50
						    	    )
						    	)
						    )
			        	)
			        )
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